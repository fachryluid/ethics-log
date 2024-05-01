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
				@if (auth()->user()->isAdmin() || auth()->user()->isManager())
					<div class="col-6 col-md-6 col-lg-3">
						<div class="card">
							<div class="card-body py-4-5 px-4">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon purple mb-2">
											<i class="iconly-boldProfile"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">Pengguna</h6>
										<h6 class="mb-0 font-extrabold">{{ $count->users }}</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-3">
						<div class="card">
							<div class="card-body py-4-5 px-4">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon red mb-2">
											<i class="iconly-boldDanger"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">Pelanggaran</h6>
										<h6 class="mb-0 font-extrabold">{{ $count->violations }}</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-6 col-lg-6">
						<div class="card">
							<div class="d-flex card-body py-4-5 gap-5 px-4">
								<div class="flex-fill">
									<table class="table-striped table-detail table">
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::PENDING" /></td>
											<td>{{ $count->pending }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::VERIFIED" /></td>
											<td>{{ $count->verified }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::FORWARDED" /></td>
											<td>{{ $count->forwarded }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::NOT_PROVEN" /></td>
											<td>{{ $count->not_proven }}</td>	
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::PROVEN_GUILTY" /></td>
											<td>{{ $count->proven_guilty }}</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				@endif

				@if (auth()->user()->isUser() || auth()->user()->isAtasan() || auth()->user()->isKomisi())
					<div class="col-6 col-md-6 col-lg-3">
						<div class="card">
							<div class="card-body py-4-5 px-4">
								<div class="row">
									<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
										<div class="stats-icon red mb-2">
											<i class="iconly-boldDanger"></i>
										</div>
									</div>
									<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
										<h6 class="text-muted font-semibold">
											@if (auth()->user()->isUser())
												Pengaduan Saya
											@else
												Pelanggaran
											@endif
										</h6>
										<h6 class="mb-0 font-extrabold">{{ $count->violations }}</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="card">
							<div class="d-flex card-body py-4-5 gap-5 px-4">
								<div class="flex-fill">
									<table class="table-striped table-detail table">
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::PENDING" /></td>
											<td>{{ $count->pending }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::VERIFIED" /></td>
											<td>{{ $count->verified }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::FORWARDED" /></td>
											<td>{{ $count->forwarded }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::NOT_PROVEN" /></td>
											<td>{{ $count->not_proven }}</td>
										</tr>
										<tr>
											<td><x-badge.violation-status :status="App\Constants\ViolationStatus::PROVEN_GUILTY" /></td>
											<td>{{ $count->proven_guilty }}</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
			{{-- <div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4>Profile Visit</h4>
						</div>
						<div class="card-body">
							<div id="chart-profile-visit"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-xl-4">
					<div class="card">
						<div class="card-header">
							<h4>Profile Visit</h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-7">
									<div class="d-flex align-items-center">
										<svg class="bi text-primary" width="32" height="32" fill="blue" style="width:10px">
											<use xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
										</svg>
										<h5 class="mb-0 ms-3">Europe</h5>
									</div>
								</div>
								<div class="col-5">
									<h5 class="mb-0 text-end">862</h5>
								</div>
								<div class="col-12">
									<div id="chart-europe"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="d-flex align-items-center">
										<svg class="bi text-success" width="32" height="32" fill="blue" style="width:10px">
											<use xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
										</svg>
										<h5 class="mb-0 ms-3">America</h5>
									</div>
								</div>
								<div class="col-5">
									<h5 class="mb-0 text-end">375</h5>
								</div>
								<div class="col-12">
									<div id="chart-america"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="d-flex align-items-center">
										<svg class="bi text-success" width="32" height="32" fill="blue" style="width:10px">
											<use xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
										</svg>
										<h5 class="mb-0 ms-3">India</h5>
									</div>
								</div>
								<div class="col-5">
									<h5 class="mb-0 text-end">625</h5>
								</div>
								<div class="col-12">
									<div id="chart-india"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="d-flex align-items-center">
										<svg class="bi text-danger" width="32" height="32" fill="blue" style="width:10px">
											<use xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
										</svg>
										<h5 class="mb-0 ms-3">Indonesia</h5>
									</div>
								</div>
								<div class="col-5">
									<h5 class="mb-0 text-end">1025</h5>
								</div>
								<div class="col-12">
									<div id="chart-indonesia"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-xl-8">
					<div class="card">
						<div class="card-header">
							<h4>Latest Comments</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table-hover table-lg table">
									<thead>
										<tr>
											<th>Name</th>
											<th>Comment</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="col-3">
												<div class="d-flex align-items-center">
													<div class="avatar avatar-md">
														<img src="{{ asset('images/default.jpg') }}">
													</div>
													<p class="mb-0 ms-3 font-bold">Si Cantik</p>
												</div>
											</td>
											<td class="col-auto">
												<p class="mb-0">Congratulations on your graduation!</p>
											</td>
										</tr>
										<tr>
											<td class="col-3">
												<div class="d-flex align-items-center">
													<div class="avatar avatar-md">
														<img src="{{ asset('images/default.jpg') }}">
													</div>
													<p class="mb-0 ms-3 font-bold">Si Ganteng</p>
												</div>
											</td>
											<td class="col-auto">
												<p class="mb-0">Wow amazing design! Can you make another tutorial for
													this design?</p>
											</td>
										</tr>
										<tr>
											<td class="col-3">
												<div class="d-flex align-items-center">
													<div class="avatar avatar-md">
														<img src="{{ asset('images/default.jpg') }}">
													</div>
													<p class="mb-0 ms-3 font-bold">Singh Eknoor</p>
												</div>
											</td>
											<td class="col-auto">
												<p class="mb-0">What a stunning design! You are so talented and creative!</p>
											</td>
										</tr>
										<tr>
											<td class="col-3">
												<div class="d-flex align-items-center">
													<div class="avatar avatar-md">
														<img src="{{ asset('images/default.jpg') }}">
													</div>
													<p class="mb-0 ms-3 font-bold">Rani Jhadav</p>
												</div>
											</td>
											<td class="col-auto">
												<p class="mb-0">I love your design! It's so beautiful and unique! How did you learn to do this?</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
		</div>
	</section>
@endsection
@push('scripts')
	<script src="{{ asset('js/extensions/apexcharts.min.js') }}"></script>
	<script src="{{ asset('js/static/dashboard.js') }}"></script>
@endpush
