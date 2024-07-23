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
use Illuminate\Support\Facades\Validator;

class AutoForward extends Command
{
    protected $signature = 'app:auto-forward';

    protected $description = 'Automatically forward verified violations that have not been updated for over 5 days.';

    public function handle()
    {
        try {
            $setting = Setting::find(1);
            $violations = Violation::where('status', ViolationStatus::VERIFIED)
                ->where('updated_at', '<=', Carbon::now()->subDays($setting->auto_forward))
                ->get();

            if ($violations->isNotEmpty()) {
                $admins = User::whereHas('admin')->get();
                $now = Carbon::now('Asia/Makassar')->format('d-m-Y H:i') . ' WITA';

                foreach ($violations as $violation) {
                    $validator = Validator::make($violation->toArray(), [
                        'nip' => 'required',
                        'class' => 'required',
                        'position' => 'required',
                    ]);

                    if ($validator->fails()) {
                        foreach ($admins as $admin) {
                            $message = $this->createIncompleteForwardMessage($admin, $violation, $setting);
                            Mail::raw($message, function ($mail) use ($admin, $now) {
                                $mail->to($admin->email)
                                    ->subject("Pengaduan Tidak Dapat Diteruskan | $now");
                            });
                        }
                        continue; // Lanjut ke pengaduan berikutnya
                    }

                    $violation->status = ViolationStatus::FORWARDED;
                    $violation->save();

                    foreach ($admins as $admin) {
                        $message = $this->createEmailMessage($violation, $admin, $setting);
    
                        Mail::raw($message, function ($mail) use ($admin, $now) {
                            $mail->to($admin->email)
                                ->subject("Laporan Pelanggaran Diteruskan | $now");
                        });
                    }

                    $this->info('Violations forwarded successfully.');
                    Log::info('Violations forwarded successfully.');
                }
            }
        } catch (\Throwable $th) {
            Log::error('Failed to auto forward violations', ['error' => $th->getMessage()]);
            $this->error('Failed to auto forward violations. Check the logs for more details.');
        }
    }

    protected function createIncompleteForwardMessage($admin, $violation, $setting)
    {
        $message = "Yth. {$admin->name},\n\n";
        $message .= "Pengaduan tidak dapat diteruskan karena data belum lengkap:\n\n";

        $message .= "Terlapor: {$violation->offender}\n";
        $message .= "Jenis: {$violation->type}\n";
        $message .= "Pangkat / Golongan: " . ($violation->class ?? '-- Belum dilengkapi --') . "\n";
        $message .= "Jabatan: " . ($violation->position ?? '-- Belum dilengkapi --') . "\n";
        $message .= "Unit Kerja: {$violation->unit_kerja->name}\n";
        $link = route('dashboard.violations.edit', $violation->uuid);
        $message .= "Tautan: {$link}\n\n";

        $message .= "Harap lengkapi data tersebut untuk melanjutkan proses.\n\n";
        $message .= "Salam,\nSistem {$setting->app_name}";

        return $message;
    }

    protected function createEmailMessage($violation, $admin, $setting)
    {
        $message = "Yth. {$admin->name},\n\n";
        $message .= "Pengaduan telah berhasil diteruskan ke Komisi Kode Etik untuk tindak lanjut.\n\n";
        $message .= "Berikut adalah detail pengaduan yang telah diteruskan:\n\n";

        $message .= "Terlapor: {$violation->offender}\n";
        $message .= "Jenis: {$violation->type}\n";
        $message .= "Pangkat / Golongan: {$violation->class}\n";
        $message .= "Jabatan: {$violation->position}\n";
        $message .= "Unit Kerja: {$violation->unit_kerja->name}\n";
        $link = route('dashboard.violations.show', $violation->uuid);
        $message .= "Tautan: {$link}\n\n";

        $message .= "Salam,\nSistem {$setting->app_name}";

        return $message;
    }
}
