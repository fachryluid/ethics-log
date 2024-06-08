@php
	use App\Constants\ViolationStatus;
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => route('dashboard.violations.show', $violation->uuid),
        'Edit Pemeriksaan' => null,
    ],
])
@section('title', 'Pemeriksaan')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Pemeriksaan</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.violations.examination.update', $violation->uuid) }}" method="PATCH" enctype="multipart/form-data">
						<x-form.input layout="horizontal" name="examination_place" label="Tempat Pemeriksaan" :value="$violation->examination_place" />
						<x-form.input layout="horizontal" type="date" name="examination_date" label="Tanggal Pemeriksaan" :value="$violation->examination_date" />
						<x-form.input layout="horizontal" type="time" name="examination_time" label="Waktu Pemeriksaan" :value="$violation->examination_time" />
						<x-form.input layout="horizontal" type="file" name="examination_report" label="Berita Acara Pemeriksaaan" />
						@if ($violation->status === ViolationStatus::PROVEN_GUILTY)
							<x-form.input layout="horizontal" type="file" name="examination_result" label="Laporan Hasil Pemeriksaan Tentang Dugaan Pelanggaran Kode Etik" />
						@endif
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
