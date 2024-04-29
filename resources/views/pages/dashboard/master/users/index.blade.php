@php
	$_USER = App\Constants\UserRole::USER;
	$_ATASAN = App\Constants\UserRole::ATASAN_UNIT_KERJA;
	$_KOMISI = App\Constants\UserRole::KOMISI_KODE_ETIK;
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Master Pengguna' => null,
    ],
])
@section('title', 'Master Pengguna')
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
						<div class="col-12">
							<label class="form-label">Jenis Pengguna</label>
							<select class="form-select filter-select">
								<option value="">Semua</option>
								<option value="pelapor">{{ $_USER }}</option>
								<option value="atasan">{{ $_ATASAN }}</option>
								<option value="komisi">{{ $_KOMISI }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Daftar Pengguna</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.master.user.create') }}" class="btn btn-primary btn-sm">
							<i class="bi bi-plus-square"></i>
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body table-responsive px-4">
					<table class="table-striped data-table table">
						<thead>
							<tr>
								<th>Nama</th>
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
					url: "{{ route('dashboard.master.user.index') }}",
					data: function(d) {
						d.type = $('.filter-select').val();
					}
				},
				columns: [{
						data: 'name',
						name: 'name'
					},
					{
						data: 'action',
						name: 'action',
						orderable: false,
						searchable: false
					}
				]
			});

			$('.filter-select').change(function() {
				table.ajax.reload();
			});
		});
	</script>
@endpush
