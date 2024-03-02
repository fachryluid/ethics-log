@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => null,
    ],
])
@section('title', 'Pelanggaran')
@push('css')
	<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
	<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title pl-1">Filter</h4>
				</div>
				<div class="card-body table-responsive px-4">
					<div class="row">
						<div class="col-6">
							<label class="form-label">Jenis Kode Etik</label>
							<select class="form-select filter-select-type">
								<option value="">Semua</option>
								@foreach (\App\Constants\EthicsCode::TYPES as $type)
									<option value="{{ $type }}">{{ $type }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-6">
							<label class="form-label">Status</label>
							<select class="form-select filter-select-status">
								<option value="">Semua</option>
								<option value="{{ \App\Constants\ViolationStatus::PENDING }}">{{ \App\Constants\ViolationStatus::PENDING }}</option>
								<option value="{{ \App\Constants\ViolationStatus::INVESTIGATING }}">{{ \App\Constants\ViolationStatus::INVESTIGATING }}</option>
								<option value="{{ \App\Constants\ViolationStatus::SUSPENDED }}">{{ \App\Constants\ViolationStatus::SUSPENDED }}</option>
								<option value="{{ \App\Constants\ViolationStatus::RESOLVED }}">{{ \App\Constants\ViolationStatus::RESOLVED }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Daftar Pelanggaran</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.violations.create') }}" class="btn btn-primary btn-sm">
							<i class="bi bi-plus-square"></i>
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body table-responsive px-4">
					<table class="table-striped data-table table">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Nama Pelaku</th>
								<th>Jenis Kode Etik</th>
								<th>Status</th>
								<th style="white-space: nowrap">Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script type="text/javascript">
		$(function() {
			const table = $('.data-table').DataTable({
				// processing: true,
				serverSide: true,
				ajax: "{{ route('dashboard.violations.index') }}",
				columns: [{
						data: 'date',
						name: 'date'
					},
					{
						data: 'offender',
						name: 'offender'
					},
					{
						data: 'type',
						name: 'type',
						orderable: false,
					},
					{
						data: 'status',
						name: 'status',
						orderable: false,
					},
					{
						data: 'action',
						name: 'action',
						orderable: false,
						searchable: false
					}
				]
			});

			$('.filter-select-type').change(function() {
				table.column(2).search($(this).val()).draw();
			});

			$('.filter-select-status').change(function() {
				table.column(3).search($(this).val()).draw();
			});
		});
	</script>
@endpush
