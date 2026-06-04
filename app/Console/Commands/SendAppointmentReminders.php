<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Services\FcmService;
use App\Enums\AppointmentStatus;
use Carbon\Carbon;

#[Signature('app:send-appointment-reminders')]
#[Description('إرسال إشعارات تذكيرية للمستخدمين قبل الحجز بـ 24 ساعة تلقائياً')]
class SendAppointmentReminders extends Command
{
    protected $fcmService;
    public function __construct(FcmService $fcmService)
    {
        parent::__construct();
        $this->fcmService = $fcmService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء فحص الحجوزات لإرسال التذكيرات غداً...');
        $startWindow = Carbon::now()->addHours(24)->startOfHour();
        $endWindow = Carbon::now()->addHours(24)->endOfHour();
        $appointments = Appointment::with('user')
            ->where('status', AppointmentStatus::Accepted->value)
            ->whereBetween('appointment_date', [$startWindow, $endWindow])
            ->get();
        if ($appointments->isEmpty()) {
            $this->info('لا توجد حجوزات تحتاج إلى تذكير في هذا الوقت.');
            return Command::SUCCESS;
        }
        foreach ($appointments as $appointment) {
            $user = $appointment->user;
            if ($user && $user->fcm_token) {
                try {
                    $this->fcmService->sendNotification(
                        $user->fcm_token,
                        'تذكير بموعدك غداً ⏰',
                        "مرحباً {$user->name}، نود تذكيرك بموعد حجزك رقم: {$appointment->id} المتبقي عليه 24 ساعة.",
                        [
                            'route' => '/appointments',
                            'appointment_id' => (string)$appointment->id
                        ]
                    );
                    $this->info("تم إرسال تذكير بنجاح للمستخدم صاحب الحجز رقم: {$appointment->id}");
                } catch (\Exception $e) {
                    $this->error("فشل إرسال التذكير للحجز رقم {$appointment->id}: " . $e->getMessage());
                }
            } else {
                $this->warn("الحجز رقم {$appointment->id} تخطى الإرسال لأن المستخدم لا يملك FCM Token.");
            }
        }
        $this->info('تم الانتهاء من معالجة كافة التذكيرات الحالية.');
        return Command::SUCCESS;
    }
}
