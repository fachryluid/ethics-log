@extends('layouts.auth')
@section('title', 'Register')
@section('content')
	<h1>Register {{ $setting->app_name }}</h1>
	<p class="auth-subtitle mb-5">{{ $setting->app_desc }}</p>
	<form action="{{ route('auth.register.submit') }}" method="POST">
		@csrf
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="text" name="name" class="form-control form-control-xl @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name') }}">
			<div class="form-control-icon">
				<i class="bi bi-person"></i>
			</div>
			@error('name')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="text" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
			<div class="form-control-icon">
				<i class="bi bi-envelope"></i>
			</div>
			@error('email')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="text" name="username" class="form-control form-control-xl @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}">
			<div class="form-control-icon">
				<i class="bi bi-person"></i>
			</div>
			@error('username')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Password">
			<div class="form-control-icon">
				<i class="bi bi-shield-lock"></i>
			</div>
			@error('password')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="password" name="password_confirmation" class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
			<div class="form-control-icon">
				<i class="bi bi-shield-lock"></i>
			</div>
			@error('password_confirmation')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>
		<button class="btn btn-primary btn-block btn-lg mt-5 shadow-lg">Register</button>
	</form>
	<div class="fs-4 mt-5 text-center text-lg">
		<p class='text-gray-600'>Sudah punya akun? <a href="{{ route('auth.login.index') }}" class="font-bold">Login</a>.</p>
	</div>
@endsection
