<?php

namespace App\Console\Commands;

use App\Constants\ViolationStatus;
use App\Models\Setting;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReportReminder extends Command
{
    protected $signature = 'app:report-reminder';

    protected $description = 'Send reminders for verified violations that have not been updated for over 5 days.';

    public function handle()
    {
        try {
            $violations = Violation::where('status', ViolationStatus::VERIFIED)
                ->where('updated_at', '<=', Carbon::now()->subDays(3))
                ->get();

            if ($violations->isNotEmpty()) {
                $admins = User::whereHas('admin')->get();
                $setting = Setting::where('id', 1)->first();
                $now = Carbon::now('Asia/Makassar')->format('d-m-Y H:i') . ' WITA';

                foreach ($admins as $admin) {
                    $message = $this->createEmailMessage($violations, $admin, $setting);

                    Mail::raw($message, function ($mail) use ($admin, $now) {
                        $mail->to($admin->email)
                            ->subject("Pengingat Laporan Pelanggaran | $now");
                    });
                }

                $this->info('Reminders sent to admins successfully.');
                Log::info('Reminders sent to admins successfully.');
            }
        } catch (\Throwable $th) {
            Log::error('Failed to send reminders to admins', ['error' => $th->getMessage()]);
            $this->error('Failed to send reminders to admins. Check the logs for more details.');
        }
    }

    protected function createEmailMessage($violations, $admin, $setting)
    {
        $message = "Yth. {$admin->name},\n\n";
        $message .= "Terdapat beberapa pengaduan yang sedang diproses dan belum diteruskan. Pengaduan tersebut akan otomatis diteruskan jika melewati batas waktu (5 hari).\n\n";
        $message .= "Pengingat ini dikirimkan H-2 sebelum batas waktu.\n\n";
        $message .= "Berikut adalah detail pengaduan:\n\n";

        foreach ($violations as $violation) {
            $message .= "Terlapor: {$violation->offender}\n";
            $message .= "Jenis: {$violation->type}\n";
            $message .= "Pangkat / Golongan: {$violation->class}\n";
            $message .= "Jabatan: {$violation->position}\n";
            $message .= "Unit Kerja: {$violation->unit_kerja->name}\n";
            $link = route('dashboard.violations.show', $violation->uuid);
            $message .= "Tautan: {$link}\n\n";
        }

        $message .= "Harap mengambil tindakan yang diperlukan.\n\n";
        $message .= "Salam,\nSistem {$setting->app_name}";

        return $message;
    }
}
