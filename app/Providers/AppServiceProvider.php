<?php

namespace App\Providers;

use App\Constants\ViolationStatus;
use App\Models\Setting;
use App\Models\Violation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $setting = Setting::where('id', 1)->first();

            $violationProcessCountQuery = Violation::query();
            if (auth()->user()) {
                if (auth()->user()->isAdmin()) {
                    $violationProcessCountQuery->where('status', ViolationStatus::VERIFIED);
                } elseif (auth()->user()->isKomisi()) {
                    $violationProcessCountQuery->where('status', ViolationStatus::FORWARDED);
                } elseif (auth()->user()->isAtasan()) {
                    $violationProcessCountQuery->where(['status' => ViolationStatus::PENDING, 'department' => auth()->user()->atasan->unit_kerja_id]);
                } else {
                    $violationProcessCountQuery->where('status', ViolationStatus::PENDING);
                }
            }
            $violationProcessCount = $violationProcessCountQuery->count();

            $view->with('setting', $setting);
            $view->with('violationProcessCount', $violationProcessCount);
        });
    }
}
