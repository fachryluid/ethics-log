@extends('layouts.export')
@section('title', 'Laporan Hasil Pengadilan')
@section('content')
	<table class="table-striped table">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Jabatan</th>
				<th>Jenis Kode Etik</th>
				<th>Status Pelanggaran</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($violations as $violation)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $violation->offender ?? '-' }}</td>
					<td>{{ $violation->nip ?? '-' }}</td>
					<td>{{ $violation->position ?? '-' }}</td>
					<td>{{ $violation->type ?? '-' }}</td>
					<td>{{ $violation->status ?? '-' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
