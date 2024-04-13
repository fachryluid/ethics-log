@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => route('dashboard.violations.show', $violation->uuid),
        'Edit' => null,
    ],
])
@section('title', 'Putusan Sidang')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Putusan Sidang</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.violations.verdict.update', $violation->uuid) }}" method="PATCH" enctype="multipart/form-data">
						<x-form.input layout="horizontal" type="date" name="session_date" label="Tanggal Sidang" />
						<x-form.input layout="horizontal" type="file" name="session_decision_report" label="Putusan Komisi Kode Etik" />
						<x-form.input layout="horizontal" type="file" name="session_official_report" label="Berita Acara Pelaksanaan Putusan Sidang Etik" />
						<x-form.select layout="horizontal" name="status" label="Putusan Sidang" :options="[
						    (object) [
						        'label' => App\Constants\ViolationStatus::PROVEN_GUILTY,
						        'value' => App\Constants\ViolationStatus::PROVEN_GUILTY,
						    ],
						    (object) [
						        'label' => App\Constants\ViolationStatus::NOT_PROVEN,
						        'value' => App\Constants\ViolationStatus::NOT_PROVEN,
						    ],
						]" />
					</x-form.layout.horizontal>
				</div>
			</div>
		</div>
	</section>
@endsection
