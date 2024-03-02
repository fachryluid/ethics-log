{{-- @dd(\App\Constants\EthicsCode::TYPES) --}}
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        'Tambah Data' => null,
    ],
])
@section('title', 'Tambah Pelanggaran')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Tambah Pelanggaran</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.violations.store') }}" method="POST">
						<x-form.input layout="horizontal" type="date" name="date" label="Tanggal Pelanggaran" />
						<x-form.input layout="horizontal" name="offender" label="Nama Pelaku" placeholder="Nama Lengkap Pelak.." />
						<x-form.textarea layout="horizontal" name="desc" label="Deskripsi" placeholder="Deskripsi Pelanggaran.." />
						<x-form.select layout="horizontal" name="type" label="Jenis Kode Etik" :options="collect(\App\Constants\EthicsCode::TYPES)->map(function ($type) {
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
@push('scripts')
@endpush
