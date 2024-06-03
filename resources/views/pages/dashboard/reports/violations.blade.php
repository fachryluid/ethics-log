@php
	$_USER = App\Constants\UserRole::USER;
	$_ATASAN = App\Constants\UserRole::ATASAN_UNIT_KERJA;
	$_KOMISI = App\Constants\UserRole::KOMISI_KODE_ETIK;
	$_ADMIN = App\Constants\UserRole::ADMIN;
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Laporan Pelanggaran' => null,
    ],
])
@section('title', 'Laporan Pelanggaran')
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
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Daftar Pelanggaran</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.reports.violations.pdf.preview') }}" class="btn btn-success btn-sm">
							<i class="bi bi-filetype-pdf"></i>
							PDF
						</a>
					</div>
				</div>
				<div class="card-body table-responsive px-4">
					<table class="table-striped data-table table">
						<thead>
							<tr>
								<th>Terlapor</th>
								<th>Jenis Kode Etik</th>
								<th>Deskripsi</th>
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
				serverSide: true,
				ajax: {
					url: "{{ route('dashboard.reports.violations') }}",
					data: function(d) {
						if ("{{ request('status') }}") {
							d.status = "{{ request('status') }}"
						}
					}
				},
				columns: [{
						data: 'offender',
						name: 'offender'
					},
					{
						data: 'type',
						name: 'type',
						orderable: false,
					},
					{
						data: 'desc',
						name: 'desc',
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
					}
				]
			});

			// $('.filter-select').change(function() {
			// 	table.ajax.reload();
			// });
		});
	</script>
@endpush
