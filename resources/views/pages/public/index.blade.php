@extends('layouts.public')
@section('title', 'Penerapan Kode Etik')
@push('css')
	<style>
		#call-to-action::before {
			background-image: url('{{ asset('storage/uploads/settings/' . $setting->auth_bg) }}');
			background-repeat: no-repeat;
			background-position: 50% 0;
			background-size: cover;
			content: ' ';
			display: block;
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			opacity: 0.15;
		}
	</style>
@endpush
@section('content')
	<section id="call-to-action" class="position-relative bg-primary d-flex w-100 align-items-start justify-content-between px-md-5 px-3 pt-5" style="min-height: 100vh;">
		<div class="col col-md-5 position-relative d-md-block d-none">
			<h1 class="text-light">Lorem ipsum dolor</h1>
			<h5 class="text-light">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam nesciunt veritatis odit earum, sit in voluptatibus repellendus dignissimos eum neque.</h5>
		</div>
		<div class="card col col-md-6 position-relative">
			<div class="card-header">
				<h5 class="card-title">Form Pengaduan</h5>
				<p class="card-text">Pelanggaran Kode Etik di lingkungan Kampus.</p>
			</div>
			<div class="card-body">
				<x-form.layout.horizontal action="{{ route('public.violation.store') }}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="from" value="{{ urlencode(url()->current()) }}">
					<h6 class="mb-4">Personal</h6>
					<x-form.input layout="horizontal" name="offender" label="Nama Terlapor" placeholder="Nama Lengkap Terlapor" />
					<x-form.input layout="horizontal" name="department" label="Unit Kerja" placeholder="Lokasi Unit Kerja Terlapor" />
					<h6 class="mb-4 mt-3">Pelanggaran</h6>
					<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
					    return (object) [
					        'label' => $type,
					        'value' => $type,
					    ];
					})" />
					<x-form.input layout="horizontal" type="date" name="date" label="Tanggal Pelanggaran" />
					<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" placeholder="Deskripsi Pelanggaran" />
					<x-form.input layout="horizontal" type="file" name="evidence" label="Bukti" />
				</x-form.layout.horizontal>
			</div>
		</div>
	</section>
@endsection
