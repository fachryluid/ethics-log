@extends('layouts.public')
@section('title', 'Penerapan Kode Etik')
@push('css')
<style>
	#call-to-action::before {
		background-image: url('{{ asset(' storage/uploads/settings/' . $setting->auth_bg) }}');
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
		<h1 class="text-white mb-4">Penerapan Kode Etik PNS di Universitas Negeri Gorontalo.</h1>
		<h5 class="text-white">
			Berdasarkan Peraturan Rektor UNG No. 199/UN47/KP tahun 2020 pada pasal 1 ayat 3, Kode Etik adalah pedoman sikap, tingkah laku, dan perbuatan Pegawai di dalam melaksanakan tugasnya dan pergaulan hidup sehari-hari.
			<br> <br>
			Diatur dalam <a href="{{ asset('files/Peraturan Rektor tentang Kode Etik PNS.pdf') }}" class="text-white text-decoration-underline">Peraturan Rektor UNG No. 199/UN47/KP tahun 2020</a>,
			Pelanggaran Etik adalah segala bentuk ucapan, tulisan, atau perbuatan Pegawai yang bertentangan dengan Kode Etik.
		</h5>
	</div>
	<div class="card col col-md-6 position-relative">
		<div class="card-header">
			<h5 class="card-title">Form Pengaduan</h5>
			<p class="card-text">Pelanggaran Kode Etik di lingkungan Universitas Negeri Gorontalo.</p>
		</div>
		<div class="card-body">
			<x-form.layout.horizontal action="{{ route('public.violation.store') }}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="from" value="{{ urlencode(url()->current()) }}">
				<h6 class="mb-4">Terlapor</h6>
				<x-form.input layout="horizontal" name="offender" label="Nama Terlapor" placeholder="Nama Lengkap Terlapor" />
				<x-form.input layout="horizontal" name="position" label="Jabatan" placeholder="Jabatan Terlapor" />
				<x-form.input layout="horizontal" name="department" label="Unit Kerja" placeholder="Lokasi Unit Kerja Terlapor" />
				<h6 class="mb-4 mt-3">Bentuk Pelanggaran Kode Etik</h6>
				<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
					    return (object) [
					        'label' => $type,
					        'value' => $type,
					    ];
					})" />
				<x-form.input layout="horizontal" type="date" name="date" label="Waktu" />
				<x-form.input layout="horizontal" name="place" label="Tempat" placeholder="Tempat Kejadian" />
				<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" placeholder="Deskripsi Pelanggaran" />
				<x-form.input layout="horizontal" type="file" name="evidence" label="Bukti / Dokumen Pendukung" />
			</x-form.layout.horizontal>
		</div>
	</div>
</section>
@endsection