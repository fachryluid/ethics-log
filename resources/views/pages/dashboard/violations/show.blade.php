@php
	$_USER = App\Constants\UserRole::USER;
	$_ADMIN = App\Constants\UserRole::ADMIN;
	$_MANAGER = App\Constants\UserRole::MANAGER;
	$role = App\Utils\AuthUtils::getRole(auth()->user());
	$title = $role == $_ADMIN ? 'Pelanggaran' : 'Pengaduan';
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        $title => route('dashboard.violations.index'),
        explode('-', $violation->uuid)[0] . '..' => null,
    ],
])
@section('title', 'Detail ' . $title)
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Detail {{ $title }}</h4>
					<div class="d-flex gap-2">
						@if (auth()->user()->isAdmin() && $violation->status === App\Constants\ViolationStatus::PENDING)
							<a href="#" class="btn btn-primary btn-sm">
								<i class="bi bi-check-circle"></i>
								Verifikasi
							</a>
						@endif
						@if (auth()->user()->isAdmin())
							<a href="{{ route('dashboard.violations.edit', $violation->uuid) }}" class="btn btn-success btn-sm">
								<i class="bi bi-pencil-square"></i>
								Edit
							</a>
						@endif
						@if (auth()->user()->isAdmin() || (auth()->user()->isUser() && $violation->status === App\Constants\ViolationStatus::PENDING))
							<x-modal.delete :id="'deleteModal-' . $violation->uuid" :route="route('dashboard.violations.destroy', $violation->uuid)" text="Hapus" />
						@endif
					</div>
				</div>
				<div class="card-body px-4">
					<table class="table-striped table-detail table">
						<tr>
							<th colspan="2">
								<h6 class="mb-0">Personal</h6>
							</th>
						</tr>
						@if ($role == $_ADMIN)
							<tr>
								<th>Nama Pelapor</th>
								<td>{{ $violation->user?->name ?? '-' }}</td>
							</tr>
						@endif
						<tr>
							<th>Nama Terlapor</th>
							<td>{{ $violation->offender }}</td>
						</tr>
						<tr>
							<th>Pangkat / Golongan</th>
							<td>{{ $violation->class ?? '-' }}</td>
						</tr>
						<tr>
							<th>Jabatan</th>
							<td>{{ $violation->position ?? '-' }}</td>
						</tr>
						<tr>
							<th>Unit Kerja</th>
							<td>{{ $violation->department }}</td>
						</tr>
						<tr>
							<th colspan="2">
								<h6 class="mb-0">Pelanggaran</h6>
							</th>
						</tr>
						<tr>
							<th>Jenis Kode Etik</th>
							<td>{{ $violation->type }}</td>
						</tr>
						<tr>
							<th>Tanggal Pelanggaran</th>
							<td>{{ $violation->date }}</td>
						</tr>
						<tr>
							<th>Deskripsi Pelanggaran</th>
							<td>{{ $violation->desc }}</td>
						</tr>
						<tr>
							<th>Status Penanganan</th>
							<td>
								<x-badge.violation-status :status="$violation->status" />
							</td>
						</tr>
						<tr>
							<th>Bukti</th>
							<td>
								<a href="{{ asset('storage/uploads/evidences/' . $violation->evidence) }}">{{ $violation->evidence }}</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
