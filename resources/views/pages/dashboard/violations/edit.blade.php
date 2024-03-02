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
						<x-form.input layout="horizontal" type="date" name="date" label="Tanggal Pelanggaran" :value="$violation->date" />
						<x-form.input layout="horizontal" name="offender" label="Nama Pelaku" placeholder="Nama Lengkap Pelak.." :value="$violation->offender" />
						<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" placeholder="Deskripsi Pelanggaran.." :value="$violation->desc" />
						<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :value="$violation->type" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
						    return (object) [
						        'label' => $type,
						        'value' => $type,
						    ];
						})" />
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
