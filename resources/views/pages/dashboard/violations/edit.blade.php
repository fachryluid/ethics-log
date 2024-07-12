@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => route('dashboard.violations.show', $violation->uuid),
        'Edit' => null,
    ],
])
@section('title', 'Edit Pelanggaran')
@push('css')
	<link rel="stylesheet" href="https://zuramai.github.io/mazer/demo/assets/extensions/choices.js/public/assets/styles/choices.css">
@endpush
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
						<x-form.select layout="horizontal" name="nip" label="Pegawai" class="choices" :value="request('nip') ?? $violation->nip" :options="$pegawais->map(function ($pegawai) {
						    return (object) [
						        'label' => $pegawai->name . ' | ' . $pegawai->nip,
						        'value' => $pegawai->nip,
						    ];
						})" />
						<x-form.input layout="horizontal" name="offender" label="Nama Terlapor" readonly :value="$selectedPegawai?->name ?? $violation->offender" />
						<x-form.input layout="horizontal" name="class" label="Pangkat / Golongan" readonly :value="$selectedPegawai?->class ?? $violation->class" />
						<x-form.input layout="horizontal" name="position" label="Jabatan" readonly :value="$selectedPegawai?->position ?? $violation->position" />
						<x-form.input layout="horizontal" name="department_readonly" label="Unit Kerja" readonly :value="$selectedPegawai?->department ?? $violation->unit_kerja->name" />
						<input type="hidden" name="department" value="{{ $selectedPegawai?->unitKerjaId }}">
						<h6 class="mb-4 mt-3">Bentuk Pelanggaran Kode Etik</h6>
						<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :value="$violation->type" :disabled="true" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
						    return (object) [
						        'label' => $type,
						        'value' => $type,
						    ];
						})" />
						{{-- <div class="col-md-4">
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
						</div> --}}
						<x-form.input layout="horizontal" type="date" name="date" label="Waktu" :value="$violation->date" :disabled="true" />
						<x-form.input layout="horizontal" name="place" label="Tempat" :value="$violation->place" :disabled="true" />
						<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" :value="$violation->desc" :disabled="true" />
						<x-form.input layout="horizontal" type="file" name="evidence" label="Bukti" :value="$violation->evidence" :disabled="true" />
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
