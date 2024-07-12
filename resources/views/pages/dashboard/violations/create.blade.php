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
@push('css')
	<link rel="stylesheet" href="https://zuramai.github.io/mazer/demo/assets/extensions/choices.js/public/assets/styles/choices.css">
@endpush
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
						
							{{-- <x-form.input layout="horizontal" name="nip" label="NIP" placeholder="Nomor Identitas Pegawai Terlapor" maxlength="18" /> --}}
							<x-form.select layout="horizontal" name="nip" label="Pegawai" class="choices" :value="request('nip')" :options="$pegawais->map(function ($pegawai) {
							    return (object) [
							        'label' => $pegawai->name . ' | ' . $pegawai->nip,
							        'value' => $pegawai->nip,
							    ];
							})" />
						
						<x-form.input layout="horizontal" name="offender" label="Nama Terlapor" :readonly="$role == $_ADMIN ? true : false" :value="$selectedPegawai?->name" />
						
							{{-- <div class="col-md-4">
								<label for="class">Pangkat / Golongan</label>
							</div>
							<div class="col-md-8 form-group">
								<select name="class" id="class" class="form-select">
									<option value="" hidden>Pilih Pangkat / Golongan</option>
									<optgroup label="Dosen PNS">
										<option value="Dosen PNS - Golongan III A">Golongan III A</option>
										<option value="Dosen PNS - Golongan III B">Golongan III B</option>
										<option value="Dosen PNS - Golongan III C">Golongan III C</option>
										<option value="Dosen PNS - Golongan III D">Golongan III D</option>
										<option value="Dosen PNS - Golongan IV A">Golongan IV A</option>
										<option value="Dosen PNS - Golongan IV B">Golongan IV B</option>
										<option value="Dosen PNS - Golongan IV C">Golongan IV C</option>
										<option value="Dosen PNS - Golongan IV D">Golongan IV D</option>
										<option value="Dosen PNS - Golongan IV E">Golongan IV E</option>
									</optgroup>
									<optgroup label="Dosen P3K">
										<option value="Dosen P3K - Golongan X">Golongan X</option>
										<option value="Dosen P3K - Golongan XI">Golongan XI</option>
									</optgroup>
									<optgroup label="Pegawai PNS">
										<option value="Pegawai PNS - Golongan II A">Golongan II A</option>
										<option value="Pegawai PNS - Golongan II B">Golongan II B</option>
										<option value="Pegawai PNS - Golongan II C">Golongan II C</option>
										<option value="Pegawai PNS - Golongan II D">Golongan II D</option>
										<option value="Pegawai PNS - Golongan III A">Golongan III A</option>
										<option value="Pegawai PNS - Golongan III B">Golongan III B</option>
										<option value="Pegawai PNS - Golongan III C">Golongan III C</option>
										<option value="Pegawai PNS - Golongan III D">Golongan III D</option>
										<option value="Pegawai PNS - Golongan IV A">Golongan IV A</option>
										<option value="Pegawai PNS - Golongan IV B">Golongan IV B</option>
										<option value="Pegawai PNS - Golongan IV C">Golongan IV C</option>
										<option value="Pegawai PNS - Golongan IV D">Golongan IV D</option>
										<option value="Pegawai PNS - Golongan IV E">Golongan IV E</option>
									</optgroup>
									<optgroup label="Pegawai P3K">
										<option value="Pegawai P3K - Golongan IX">Golongan IX</option>
									</optgroup>
								</select>
							</div> --}}
							<x-form.input layout="horizontal" name="class" label="Pangkat / Golongan" readonly :value="$selectedPegawai?->class" />
							{{-- <x-form.select layout="horizontal" name="position" label="Jabatan" :options="collect(\App\Constants\Options::JABATAN)->map(function ($class) {
							    return (object) [
							        'label' => $class,
							        'value' => $class,
							    ];
							})" /> --}}
							<x-form.input layout="horizontal" name="position" label="Jabatan" readonly :value="$selectedPegawai?->position" />
						
						
							<x-form.input layout="horizontal" name="department_readonly" label="Unit Kerja" readonly :value="$selectedPegawai?->department" />
							<input type="hidden" name="department" value="{{ $selectedPegawai?->unitKerjaId }}">
						
							{{-- <x-form.select layout="horizontal" name="department" label="Unit Kerja" :options="$units->map(function ($unit) {
							    return (object) [
							        'label' => $unit->name,
							        'value' => $unit->id,
							    ];
							})" /> --}}
						
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
	<script src="https://zuramai.github.io/mazer/demo/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
	<script src="https://zuramai.github.io/mazer/demo/assets/static/js/pages/form-element-select.js"></script>
	<script>
		const pegawai = document.getElementById('nip');
		pegawai.addEventListener('change', (e) => {
			const selectedOption = pegawai.options[pegawai.selectedIndex].value;
			let currentUrl = window.location.href;
			let updatedUrl = new URL(currentUrl);
			updatedUrl.searchParams.set('nip', selectedOption);
			window.location.href = updatedUrl.toString();
		});
	</script>
@endpush
