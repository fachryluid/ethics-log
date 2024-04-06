@php
	$_USER = App\Constants\UserRole::USER;
	$_ADMIN = App\Constants\UserRole::ADMIN;
	$_MANAGER = App\Constants\UserRole::MANAGER;
	$role = App\Utils\AuthUtils::getRole(auth()->user());
	$title = $role == $_ADMIN ? 'Pelanggaran' : 'Pengaduan';
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        $title => route('dashboard.violations.index'),
        'Tambah Data' => null,
    ],
])
@section('title', 'Tambah ' . $title)
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Tambah {{ $title }}</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.violations.store') }}" method="POST" enctype="multipart/form-data">
						<h6 class="mb-4">Terlapor</h6>
						{{-- @if ($role == $_ADMIN)
							<x-form.input layout="horizontal" name="nip" label="NIP" placeholder="Nomor Identitas Pegawai Terlapor" maxlength="18" />
						@endif --}}
						<x-form.input layout="horizontal" name="offender" label="Nama Terlapor" placeholder="Nama Lengkap Terlapor" />
						{{-- @if ($role == $_ADMIN)
							<x-form.select layout="horizontal" name="class" label="Pangkat / Golongan" :options="collect(\App\Constants\EthicsCode::ASN_CLASS)->map(function ($class) {
							    return (object) [
							        'label' => $class,
							        'value' => $class,
							    ];
							})" />
						@endif --}}
						{{-- <x-form.input layout="horizontal" name="position" label="Jabatan" placeholder="Jabatan Terlapor" /> --}}
						<x-form.select layout="horizontal" name="department" label="Unit Kerja" :options="$units->map(function ($unit) {
						    return (object) [
						        'label' => $unit->name,
						        'value' => $unit->id,
						    ];
						})" />
						<h6 class="mb-4 mt-3">Bentuk Pelanggaran Kode Etik</h6>
						<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
						    return (object) [
						        'label' => $type,
						        'value' => $type,
						    ];
						})" />
						{{-- @if ($role == $_ADMIN)
							<div class="col-md-4">
								<label>Ketentuan</label>
							</div>
							<div class="col-md-4 form-group">
								<input type="text" class="form-control @error('regulation_section') is-invalid @enderror" name="regulation_section" id="regulation_section" placeholder="Pasal" />
								@error('regulation_section')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-md-4 form-group">
								<input type="text" class="form-control @error('regulation_letter') is-invalid @enderror" name="regulation_letter" id="regulation_letter" placeholder="Huruf" />
								@error('regulation_letter')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-md-4">
								<label>Peraturan Menteri Pendidikan dan Kebudayaan</label>
							</div>
							<div class="col-md-2 form-group">
								<input type="text" class="form-control @error('regulation_number') is-invalid @enderror" name="regulation_number" id="regulation_number" placeholder="Nomor" />
								@error('regulation_number')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-md-2 form-group">
								<input type="text" class="form-control @error('regulation_year') is-invalid @enderror" name="regulation_year" id="regulation_year" placeholder="Tahun" />
								@error('regulation_year')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-md-4 form-group">
								<input type="text" class="form-control @error('regulation_about') is-invalid @enderror" name="regulation_about" id="regulation_about" placeholder="Tentang" />
								@error('regulation_about')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						@endif --}}
						<x-form.input layout="horizontal" type="date" name="date" label="Waktu" />
						<x-form.input layout="horizontal" name="place" label="Tempat" placeholder="Tempat Kejadian" />
						<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" placeholder="Deskripsi Pelanggaran" />
						<x-form.input layout="horizontal" type="file" name="evidence" label="Bukti / Dokumen Pendukung" />
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
@endpush
