<?php

namespace App\Console\Commands;

use App\Enums\AppointmentStatus;
use Illuminate\Console\Command;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckPendingPayments extends Command
{
    protected $signature = 'payments:check-status';
    protected $description = 'التحقق من جلسات Stripe المعلقة وتحديث حالة الحجوزات كل ساعة';

    protected $paymentRepository;
    protected $appointmentRepository;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        AppointmentRepositoryInterface $appointmentRepository
    ) {
        parent::__construct();
        $this->paymentRepository = $paymentRepository;
        $this->appointmentRepository = $appointmentRepository;
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
                    $this->info("تم تأكيد الحجز رقم: {$payment->appointment_id} بنجاح.");
                }
                else {
                    if ($session->status === 'open') {
                        // if ($payment->created_at->diffInMinutes(now()) < 30) {
                        //     continue;
                        // }
                        $session->expire();
                    }
                    $this->paymentRepository->update($payment->id, [
                        'status' => 'unpaid'
                    ]);
                    $this->appointmentRepository->update($payment->appointment_id, [
                        'status' => AppointmentStatus::Rejected->value
                    ]);

                    $this->error("تم إلغاء الرابط المفتوح وتغيير حالة الحجز رقم: {$payment->appointment_id} إلى مرفوض لعدم الدفع.");
                }

            } catch (\Exception $e) {
                $this->error("خطأ أثناء فحص الدفعة رقم {$payment->id}: " . $e->getMessage());
            }
        }

        $this->info('تم الانتهاء من فحص جميع المدفوعات.');
        return Command::SUCCESS;
    }
}
