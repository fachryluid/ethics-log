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
		<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
		@stack('css')
	</head>

	<body>
		<script src="{{ asset('js/initTheme.js') }}"></script>
		<div id="auth">
			<div class="row h-100">
				<div class="col-lg-5 col-12">
					<div id="auth-left">
						@yield('content')
					</div>
				</div>
				<div class="col-lg-7 d-none d-lg-block bg-primary p-0 position-relative">
					@if ($setting->auth_bg)
						<img src="{{ asset('storage/uploads/settings/' . $setting->auth_bg) }}" alt="Background" class="object-fit-cover w-100 h-100 opacity-25">
					@endif
					<div class="position-absolute top-0 p-5">
						<h1 class="text-white mb-4">Penerapan Kode Etik PNS di Universitas Negeri Gorontalo.</h1>
						<h5 class="text-white">
							Berdasarkan Peraturan Rektor UNG No. 199/UN47/KP tahun 2020 pada pasal 1 ayat 3, Kode Etik adalah pedoman sikap, tingkah laku, dan perbuatan Pegawai di dalam melaksanakan tugasnya dan pergaulan hidup sehari-hari.
							<br> <br>
							Diatur dalam <a href="{{ asset('files/Peraturan Rektor tentang Kode Etik PNS.pdf') }}" class="text-white text-decoration-underline">Peraturan Rektor UNG No. 199/UN47/KP tahun 2020</a>,
							Pelanggaran Etik adalah segala bentuk ucapan, tulisan, atau perbuatan Pegawai yang bertentangan dengan Kode Etik.
						</h5>
					</div>
				</div>
			</div>
		</div>

		<script src="{{ asset('js/dark.js') }}"></script>
		<script src="{{ asset('js/extensions/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		@stack('scripts')
	</body>

</html>
