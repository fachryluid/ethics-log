<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthenticateRequest;
use App\Http\Requests\RegisterSubmitRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function login_index()
    {
        return view('pages.auth.login');
    }

    public function login_authenticate(LoginAuthenticateRequest $request)
    {
        $field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            return redirect()
                ->route('dashboard.index')
                ->withSuccess('Selamat datang!');
        }

        return redirect()
            ->back()
            ->withErrors(['message' => 'Ups! Username atau password salah']);
    }

    public function register_index()
    {
        return view('pages.auth.register');
    }

    public function register_submit(RegisterSubmitRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect()
                ->route('dashboard.index')
                ->with('success', 'Akun berhasil dibuat.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()
            ->route('auth.login.index');
    }
}
