@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => null,
    ],
])
@section('title', 'Detail Pelanggaran')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Detail Pelanggaran</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.violations.edit', $violation->uuid) }}" class="btn btn-success btn-sm">
							<i class="bi bi-pencil-square"></i>
							Edit
						</a>
						<x-modal.delete :id="'deleteModal-'. $violation->uuid" :route="route('dashboard.violations.destroy', $violation->uuid)" text="Hapus" />
					</div>
				</div>
				<div class="card-body px-4">
					<table class="table-striped table-detail table">
						<tr>
							<th>Tanggal Pelanggaran</th>
							<td>{{ $violation->date }}</td>
						</tr>
						<tr>
							<th>Nama Pelaku</th>
							<td>{{ $violation->offender }}</td>
						</tr>
						<tr>
							<th>Jenis Kode Etik</th>
							<td>{{ $violation->type }}</td>
						</tr>
						<tr>
							<th>Deskripsi Pelanggaran</th>
							<td>{{ $violation->desc }}</td>
						</tr>
						<tr>
							<th>Status</th>
							<td>{{ $violation->status }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
