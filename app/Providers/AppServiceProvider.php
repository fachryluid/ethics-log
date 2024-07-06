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
            $violationProcessCount = Violation::where('status', ViolationStatus::VERIFIED)->count();

            $view->with('setting', $setting);
            $view->with('violationProcessCount', $violationProcessCount);
        });
    }
}
