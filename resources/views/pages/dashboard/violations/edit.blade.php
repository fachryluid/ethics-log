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
						<h6 class="mb-4">Personal</h6>
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
						<x-form.input layout="horizontal" type="date" name="date" label="Tanggal Pelanggaran" :value="$violation->date" />
						<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" placeholder="Deskripsi Pelanggaran" :value="$violation->desc" />
						<x-form.input layout="horizontal" type="file" name="evidence" label="Bukti" :value="$violation->evidence" />
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
