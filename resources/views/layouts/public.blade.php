<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ $setting->app_name }} - @yield('title')</title>
		<link rel="shortcut icon" href="{{ $setting->app_logo ? asset('storage/uploads/settings/' . $setting->app_logo) : asset('images/default/jejakode.svg') }}" type="image/x-icon">
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<link rel="stylesheet" href="{{ asset('css/app-dark.css') }}">
		@stack('css')
		<style>
			#public {
				width: 100%;
				height: 100vh;
			}
		</style>
	</head>

	<body>
		<script src="{{ asset('js/initTheme.js') }}"></script>
		<div id="public">
			<div class="w-100 d-flex justify-content-between align-items-center px-md-5 bg-white px-3 py-2">
				@if ($setting->app_logo)
					<div class="d-flex align-items-center gap-2">
						<img src="{{ asset('storage/uploads/settings/' . $setting->app_logo) }}" alt="Logo" srcset="" style="height: 20px;">
						<span class="fw-bold fs-4">{{ $setting->app_name }}</span>
					</div>
				@else
					<div class="d-flex align-items-center gap-2">
						<img src="{{ asset('images/default/jejakode.svg') }}" alt="Logo" srcset="" style="height: 20px;">
						<span class="fw-bold fs-4">{{ $setting->app_name }}</span>
					</div>
				@endif
				<div class="d-flex justify-content-center align-items-center gap-2">
					@auth
						<a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-sm fw-medium">Dashboard</a>
					@else
						<a href="{{ route('auth.login.index') }}" class="btn btn-primary btn-sm fw-medium">Login</a>
						<a href="{{ route('auth.register.index') }}" class="btn btn-secondary btn-sm fw-medium">Register</a>
					@endauth
				</div>
			</div>
			@yield('content')
		</div>

		<script src="{{ asset('js/dark.js') }}"></script>
		<script src="{{ asset('js/extensions/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		@stack('scripts')
	</body>

</html>
