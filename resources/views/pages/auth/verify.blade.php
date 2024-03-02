@extends('layouts.auth')
@section('title', 'Verifikasi Email')
@section('content')
	<h1>Verifikasi Email</h1>
	<p class="auth-subtitle">Mohon periksa kotak masuk email Anda. Jika Anda tidak menerima pesan, silakan coba kirim ulang.</p>
	<x-main.alerts />
	<form action="{{ route('verification.send') }}" method="POST">
		@csrf
		<button type="submit" class="btn btn-primary btn-block btn-lg mt-4 shadow-lg">Kirim Ulang</button>
	</form>
@endsection
