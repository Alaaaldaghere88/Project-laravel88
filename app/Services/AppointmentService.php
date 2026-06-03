<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Http\Resources\AppointmentResource;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Traits\BaseResponse;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Illuminate\Http\Exceptions\HttpResponseException;
use Stripe\Refund;

class AppointmentService
{
    use BaseResponse;

    protected $appointmentRepository;
    protected $paymentRepository;
    protected $propertyRepository;

    public function __construct(
        AppointmentRepositoryInterface $appointmentRepository,
        PaymentRepositoryInterface $paymentRepository,
        PropertyRepositoryInterface $propertyRepository
    ) {
        $this->appointmentRepository = $appointmentRepository;
        $this->paymentRepository = $paymentRepository;
        $this->propertyRepository = $propertyRepository;
    }

    public function createAppointment(array $data)
    {
        $this->sameDay($data);
        $property=$this->propertyRepository->getById($data['property_id']);
        $days_num = $data['days_num'] ?? 1;
        $price=$property->price * ($data['days_num'] ?? 1);
        $data['total_price'] = $price;
        $data['days_num'] = $days_num;
         $data['user_id'] = auth()->id();
    //      $days_num = isset($data['days_num']) ? (int) $data['days_num'] : 1;
    // $appointmentDate = \Carbon\Carbon::parse($data['appointment_date']);
        DB::beginTransaction();
        try {
            $appointment = $this->appointmentRepository->create($data);
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            $data['amount'] = $price;
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'حجز موعد/فيلا رقم: ' . $appointment->id,
                        ],
                        'unit_amount' => $data['amount'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                    'appointment_id' => $appointment->id,
                ],
                'success_url' => $frontendUrl . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $frontendUrl . '/payment-cancel',
            ]);

            $this->paymentRepository->create([
                'appointment_id' => $appointment->id,
                'amount' => $data['amount'],
                'stripe_session_id' => $checkout_session->id,
                'stripe_session_url' => $checkout_session->url,
            ]);

            DB::commit();
            return $this->successResponse(__('messages.created_done'), [
                'appointment' => AppointmentResource::make($appointment),
                'payment_url' => $checkout_session->url
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('messages.Failed') . ': ' . $e->getMessage(), 500);
        }
    }
    public function updateAppointment(int $id, array $data)
    {
        $this->checkAccess($id);
        $this->sameDay($data);
        $this->canUpdateOrDelete($id);
        return $this->successResponse(
            __('messages.updated_done'),
            AppointmentResource::make($this->appointmentRepository->update($id, $data))
        );
    }
    public function deleteAppointment(int $id)
    {
        $this->checkAccess($id);
        $this->canUpdateOrDelete($id);
        $this->appointmentRepository->delete($id);
        return $this->successResponse(__('messages.deleted_done'));
    }
    public function getAppointmentById(int $id)
    {
        $this->checkAccess($id);
        $appointment = $this->appointmentRepository->getById($id);
        return $this->successResponse(__('messages.retrieved_successfully'), AppointmentResource::make($appointment));
    }
    public function getAllAppointments()
    {
        $user = auth()->user();
        if ($this->isAdmin()) {
            $appointments = $this->appointmentRepository->getAll();
        } else {
            $appointments = $this->appointmentRepository->getAccessibleAppointments($user->id);
        }
        return $this->successResponse(
            __('messages.retrieved_successfully'),
            AppointmentResource::collection($appointments)
        );
    }
    public function cancelAppointment(int $id)
    {
    $this->checkAccess($id);
    $appointment = $this->appointmentRepository->getById($id);

    if ($appointment->status != AppointmentStatus::Accepted) {
        return $this->errorResponse(__('messages.Only accepted appointments can be cancelled.'), 422);
    }
    DB::beginTransaction();
    try {
        $payment = $appointment->payment;
        if ($payment && $payment->stripe_session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::retrieve($payment->stripe_session_id);
            if ($session->payment_status !== 'paid') {
                return $this->errorResponse(__('messages.Cannot refund: The payment for this session has not been completed.'), 400);
            }
            if ($session->payment_intent) {
                Refund::create(['payment_intent' => $session->payment_intent]);
            } else {
                return $this->errorResponse(__('messages.Refund failed: No payment intent associated with this session.'), 400);
            }
        }
         $data['status'] = AppointmentStatus::Rejected;
        $this->appointmentRepository->update($id, $data);
        if ($payment) {
            $this->paymentRepository->update($payment->id, ['status' => 'refunded']);
        }
        DB::commit();
        return $this->successResponse(__('messages.Appointment cancelled and refund processed successfully'), AppointmentResource::make($appointment));

       } catch (\Exception $e) {
        DB::rollBack();
        return $this->errorResponse(__('messages.Failed') . ': ' . $e->getMessage(), 500);
       }
    }
    public function checkAccess($id)
    {
        $appointment = $this->appointmentRepository->getById($id);
        if (!$appointment) {
            throw new HttpResponseException($this->errorResponse(__('messages.not_found'), 404));
        }
        if (!$this->isAdmin() && !$this->isOwner($appointment) && !$this->isUser($appointment)) {
            throw new HttpResponseException($this->errorResponse(__('messages.Unauthorized'), 403));
        }
    }
    public function isAdmin()
    {
        return auth()->user()->hasRole('admin');
    }
    public function isOwner($appointment)
    {
        return auth()->user()->id === $appointment->property->user_id;
    }
    public function isUser($appointment)
    {
        return auth()->user()->id === $appointment->user_id;
    }
    public function sameDay($data)
    {
        if ($this->appointmentRepository->sameDay($data)) {
            throw new HttpResponseException($this->errorResponse(__('messages.Appointment already exists for this property on the selected date.'), 422));
        }
    }
    public function canUpdateOrDelete($id)
    {
        $appointment = $this->appointmentRepository->getById($id);
          if ($appointment->status !=AppointmentStatus::Pending) {
            throw new HttpResponseException($this->errorResponse(__('messages.Only pending appointments can be updated.'), 422));
        }
    }
    public function filterAppointments(array $filters)
    {
        $appointments = $this->appointmentRepository->filter($filters);
        return $this->successResponse(__('messages.retrieved_successfully'), AppointmentResource::collection($appointments));
    }

}
