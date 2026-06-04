<?php

namespace App\Console\Commands;

use App\Enums\AppointmentStatus;
use Illuminate\Console\Command;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Models\Payment;
use App\Models\Appointment;
use App\Notifications\CustomNotification;
use App\Services\FcmService;
use Illuminate\Support\Facades\Notification;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckPendingPayments extends Command
{
    protected $signature = 'payments:check-status';
    protected $description = 'التحقق من جلسات Stripe المعلقة وتحديث حالة الحجوزات كل ساعة';

    protected $paymentRepository;
    protected $appointmentRepository;
    protected $fcmService;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        AppointmentRepositoryInterface $appointmentRepository,
        FcmService $fcmService
    ) {
        parent::__construct();
        $this->paymentRepository = $paymentRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->fcmService = $fcmService;
    }

    public function handle()
    {
        $this->info('بدء فحص المدفوعات المعلقة...');

        $pendingPayments = Payment::where('status', 'pending')
                                  ->whereNotNull('stripe_session_id')
                                  ->get();

        if ($pendingPayments->isEmpty()) {
            $this->info('لا توجد مدفوعات معلقة حالياً.');
            return Command::SUCCESS;
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        foreach ($pendingPayments as $payment) {
            try {
                $session = Session::retrieve($payment->stripe_session_id);
                if ($session->payment_status === 'paid') {
                    $this->paymentRepository->update($payment->id, [
                        'status' => 'paid',
                        'stripe_payment_intent_id' => $session->payment_intent,
                    ]);
                    $this->appointmentRepository->update($payment->appointment_id, [
                        'status' => AppointmentStatus::Accepted->value,
                    ]);
                    $this->fcmService->sendNotification(
                        $payment->appointment->user->fcm_token,
                        __('messages.Accept appointment successfully'),
                        __("messages.Accept appointment number", ['id' => $payment->appointment_id])
                    );
                    Notification::send($payment->appointment->user, new CustomNotification(
                        __('messages.Accept appointment successfully'),
                        __("messages.Accept appointment number", ['id' => $payment->appointment_id])
                    ));
                }
                else {
                    if ($session->status === 'open') {
                        $session->expire();
                    }
                    $this->paymentRepository->update($payment->id, [
                        'status' => 'unpaid'
                    ]);
                    $this->appointmentRepository->update($payment->appointment_id, [
                        'status' => AppointmentStatus::Rejected->value
                    ]);
                        $this->fcmService->sendNotification(
                            $payment->appointment->user->fcm_token,
                            __('messages.Reject appointment successfully'),
                            __("messages.Reject appointment number", ['id' => $payment->appointment_id])
                        );
                    Notification::send($payment->appointment->user, new CustomNotification(
                        __('messages.Reject appointment successfully'),
                        __("messages.Reject appointment number", ['id' => $payment->appointment_id])
                    ));
                }

            } catch (\Exception $e) {
                $this->error("خطأ أثناء فحص الدفعة رقم {$payment->id}: " . $e->getMessage());
            }
        }
        return Command::SUCCESS;
    }
}
