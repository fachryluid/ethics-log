<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (isset($request->from)) {
            Session::flash('error', 'Anda harus login terlebih dahulu.');
            return route('auth.login.index', ['from' => $request->from]);
        }

        return $request->expectsJson() ? null : route('auth.login.index');
    }
}
