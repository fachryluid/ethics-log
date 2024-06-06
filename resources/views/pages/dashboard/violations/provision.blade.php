@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => route('dashboard.violations.show', $violation->uuid),
        'Edit Ketentuan' => null,
    ],
])
@section('title', 'Edit Ketentuan')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Edit Ketentuan</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.violations.provision.update', $violation->uuid) }}" method="PATCH" submit-text="Perbarui">
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
							<input type="text" class="form-control @error('regulation_letter') is-invalid @enderror" name="regulation_letter" id="regulation_letter" placeholder="Ayat" value="{{ old('regulation_letter') ?? $violation->regulation_letter }}" />
							@error('regulation_letter')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-4">
							<label>Peraturan Rektor Universitas Negeri Gorontalo</label>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-6 form-group">
									<input type="text" class="form-control @error('regulation_number') is-invalid @enderror" name="regulation_number" id="regulation_number" placeholder="Nomor" value="199/UN47/KP/2020" disabled />
									@error('regulation_number')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-6 form-group">
									<input type="text" class="form-control @error('regulation_year') is-invalid @enderror" name="regulation_year" id="regulation_year" placeholder="Tahun" value="2020" disabled />
									@error('regulation_year')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-12 form-group">
									<input type="text" class="form-control @error('regulation_about') is-invalid @enderror" name="regulation_about" id="regulation_about" placeholder="Tentang" value="Kode Etik Pegawai Negeri Sipil di Lingkungan Universitas Negeri Gorontalo" disabled />
									@error('regulation_about')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
