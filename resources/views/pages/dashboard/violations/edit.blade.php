@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => route('dashboard.violations.show', $violation->uuid),
        'Edit' => null,
    ],
])
@section('title', 'Edit Pelanggaran')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Edit Pelanggaran</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.violations.update', $violation->uuid) }}" method="PUT" submit-text="Perbarui">
						<h6 class="mb-4">Terlapor</h6>
						<x-form.input layout="horizontal" name="nip" label="NIP" placeholder="Nomor Identitas Pegawai Terlapor" maxlength="18" :value="$violation->nip" />
						<x-form.input layout="horizontal" name="offender" label="Nama Terlapor" placeholder="Nama Lengkap Terlapor" :value="$violation->offender" />
						<x-form.select layout="horizontal" name="class" label="Pangkat / Golongan" :value="$violation->class" :options="collect(\App\Constants\EthicsCode::ASN_CLASS)->map(function ($class) {
						    return (object) [
						        'label' => $class,
						        'value' => $class,
						    ];
						})" />
						<x-form.input layout="horizontal" name="position" label="Jabatan" placeholder="Jabatan Terlapor" :value="$violation->position" />
						<x-form.input layout="horizontal" name="department" label="Unit Kerja" placeholder="Lokasi Unit Kerja Terlapor" :value="$violation->department" />
						<h6 class="mb-4 mt-3">Pelanggaran</h6>
						<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :value="$violation->type" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
						    return (object) [
						        'label' => $type,
						        'value' => $type,
						    ];
						})" />
						<div class="col-md-4">
							<label>Ketentuan</label>
						</div>
						<div class="col-md-4 form-group">
							<input type="text" class="form-control @error('regulation_section') is-invalid @enderror" name="regulation_section" id="regulation_section" placeholder="Pasal" value="{{ old('regulation_section') ?? $violation->regulation_section }}" />
							@error('regulation_section')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-4 form-group">
							<input type="text" class="form-control @error('regulation_letter') is-invalid @enderror" name="regulation_letter" id="regulation_letter" placeholder="Huruf" value="{{ old('regulation_letter') ?? $violation->regulation_letter }}" />
							@error('regulation_letter')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-4">
							<label>Peraturan Menteri Pendidikan dan Kebudayaan</label>
						</div>
						<div class="col-md-2 form-group">
							<input type="text" class="form-control @error('regulation_number') is-invalid @enderror" name="regulation_number" id="regulation_number" placeholder="Nomor" value="{{ old('regulation_number') ?? $violation->regulation_number }}" />
							@error('regulation_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-2 form-group">
							<input type="text" class="form-control @error('regulation_year') is-invalid @enderror" name="regulation_year" id="regulation_year" placeholder="Tahun" value="{{ old('regulation_year') ?? $violation->regulation_year }}" />
							@error('regulation_year')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-4 form-group">
							<input type="text" class="form-control @error('regulation_about') is-invalid @enderror" name="regulation_about" id="regulation_about" placeholder="Tentang" value="{{ old('regulation_about') ?? $violation->regulation_about }}" />
							@error('regulation_about')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<x-form.input layout="horizontal" type="date" name="date" label="Waktu" :value="$violation->date" />
						<x-form.input layout="horizontal" name="place" label="Tempat" :value="$violation->place" />
						<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" :value="$violation->desc" />
						<x-form.input layout="horizontal" type="file" name="evidence" label="Bukti" :value="$violation->evidence" />
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
