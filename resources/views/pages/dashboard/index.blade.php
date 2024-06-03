@php
	use App\Constants\ViolationStatus;
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dashboard' => null,
    ],
])
@section('title', 'Dashboard')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/iconly.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="row">
				@if (auth()->user()->isAdmin())
					<div class="col-6 col-md-6 col-lg-4">
						<div class="card border border-2">
							<div class="card-body py-4-5 d-flex justify-content-between px-4">
								<div class="d-flex flex-column">
									<div class="stats-icon purple mb-3">
										<i class="iconly-boldProfile"></i>
									</div>
									<h6 class="text-muted font-semibold">Pengguna</h6>
									<a href="{{ route('dashboard.master.user.index') }}" class="fw-bold">
										Detail
										<i class="bi bi-arrow-right-short"></i>
									</a>
								</div>
								<h1 class="mb-0 font-extrabold">{{ $count->users }}</h1>
							</div>
						</div>
					</div>
				@endif
				<div class="col-6 col-md-6 col-lg-4">
					<div class="card border border-2">
						<div class="card-body py-4-5 d-flex justify-content-between px-4">
							<div class="d-flex flex-column">
								<div class="stats-icon red mb-3">
									<i class="iconly-boldDanger"></i>
								</div>
								<h6 class="text-muted font-semibold">
									@if (auth()->user()->isUser())
										Pengaduan Saya
									@else
										Pelanggaran
									@endif
								</h6>
								<a href="{{ route('dashboard.violations.index') }}" class="fw-bold">
									Detail
									<i class="bi bi-arrow-right-short"></i>
								</a>
							</div>
							<h1 class="mb-0 font-extrabold">{{ $count->violations }}</h1>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-6 col-lg-4">
					<div class="card border border-2">
						<div class="card-body py-4-5 d-flex justify-content-between px-4">
							<div class="d-flex flex-column">
								<div class="stats-icon bg-primary mb-3">
									<i class="iconly-boldTime-Circle"></i>
								</div>
								<h6 class="text-muted font-semibold">Pending</h6>
								@if (auth()->user()->isManager())
									<a href="{{ route('dashboard.reports.violations', ['status' => ViolationStatus::PENDING]) }}" class="fw-bold">
										Detail
										<i class="bi bi-arrow-right-short"></i>
									</a>
								@endif
							</div>
							<h1 class="mb-0 font-extrabold">{{ $count->pending }}</h1>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-6 col-lg-4">
					<div class="card border border-2">
						<div class="card-body py-4-5 d-flex justify-content-between px-4">
							<div class="d-flex flex-column">
								<div class="stats-icon bg-warning mb-3">
									<i class="iconly-boldSetting"></i>
								</div>
								<h6 class="text-muted font-semibold">Proses</h6>
								@if (auth()->user()->isManager())
									<a href="{{ route('dashboard.reports.violations', ['status' => ViolationStatus::VERIFIED]) }}" class="fw-bold">
										Detail
										<i class="bi bi-arrow-right-short"></i>
									</a>
								@endif
							</div>
							<h1 class="mb-0 font-extrabold">{{ $count->verified }}</h1>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-6 col-lg-4">
					<div class="card border border-2">
						<div class="card-body py-4-5 d-flex justify-content-between px-4">
							<div class="d-flex flex-column">
								<div class="stats-icon bg-secondary mb-3">
									<i class="iconly-boldArrow---Right"></i>
								</div>
								<h6 class="text-muted font-semibold">Diteruskan ke Komisi Kode Etik</h6>
								@if (auth()->user()->isManager())
									<a href="{{ route('dashboard.reports.violations', ['status' => ViolationStatus::FORWARDED]) }}" class="fw-bold">
										Detail
										<i class="bi bi-arrow-right-short"></i>
									</a>
								@endif
							</div>
							<h1 class="mb-0 font-extrabold">{{ $count->forwarded }}</h1>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-6 col-lg-4">
					<div class="card border border-2">
						<div class="card-body py-4-5 d-flex justify-content-between px-4">
							<div class="d-flex flex-column">
								<div class="stats-icon bg-success mb-3">
									<i class="iconly-boldClose-Square"></i>
								</div>
								<h6 class="text-muted font-semibold">Tidak Terbukti</h6>
								@if (auth()->user()->isManager())
									<a href="{{ route('dashboard.reports.violations', ['status' => ViolationStatus::NOT_PROVEN]) }}" class="fw-bold">
										Detail
										<i class="bi bi-arrow-right-short"></i>
									</a>
								@endif
							</div>
							<h1 class="mb-0 font-extrabold">{{ $count->not_proven }}</h1>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-6 col-lg-4">
					<div class="card border border-2">
						<div class="card-body py-4-5 d-flex justify-content-between px-4">
							<div class="d-flex flex-column">
								<div class="stats-icon bg-danger mb-3">
									<i class="iconly-boldTick-Square"></i>
								</div>
								<h6 class="text-muted font-semibold">Terbukti</h6>
								@if (auth()->user()->isManager())
									<a href="{{ route('dashboard.reports.violations', ['status' => ViolationStatus::PROVEN_GUILTY]) }}" class="fw-bold">
										Detail
										<i class="bi bi-arrow-right-short"></i>
									</a>
								@endif
							</div>
							<h1 class="mb-0 font-extrabold">{{ $count->proven_guilty }}</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="{{ asset('js/extensions/apexcharts.min.js') }}"></script>
	<script src="{{ asset('js/static/dashboard.js') }}"></script>
@endpush
