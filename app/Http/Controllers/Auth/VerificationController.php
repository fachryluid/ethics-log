<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function show(): View
    {
        return view('pages.auth.verify');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard.index');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return redirect()->back()->with('success', 'Tautan verifikasi berhasil terkirim!');
    }
}
