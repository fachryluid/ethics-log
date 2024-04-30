@extends('layouts.surat')
@section('title', 'SURAT PERNYATAAN PERMOHONAN MAAF')
@push('css')
	<style>
		.content p {
			line-height: 1.5;
		}
	</style>
@endpush
@section('content')
	<div style="text-align: center; margin-top: 30px; margin-bottom: 10px;">SURAT PERNYATAAN</div>
	<div style="text-align: center; margin-bottom: 30px;">
		<div style="margin-bottom: 10px;">PERMOHONAN MAAF</div>
		<div>Nomor: {{ request('aa') ?? '...' }} / {{ request('bb') ?? '...' }} / {{ request('cc') ?? '...' }} / {{ request('dd') ?? '...' }}</div>
	</div>
	<div style="margin-bottom: 60px; list-style-type: none;">
		<p>Yang bertanda tangan di bawah ini:</p>
		<table style="margin: 20px 0;">
			<tr>
				<td style="width: 200px">Nama</td>
				<td style="width: 10px">:</td>
				<td>{{ $violation->offender }}</td>
			</tr>
			<tr>
				<td>NIP</td>
				<td>:</td>
				<td>{{ $violation->nip }}</td>
			</tr>
			<tr>
				<td>Pangkat / Golongan Ruang</td>
				<td>:</td>
				<td>{{ $violation->class }}</td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td>:</td>
				<td>{{ $violation->position }}</td>
			</tr>
			<tr>
				<td>Unit Kerja</td>
				<td>:</td>
				<td>{{ $violation->unit_kerja->name }}</td>
			</tr>
		</table>
		<p style="margin-bottom: 20px; text-align: justify;">
			dengan ini memohon maaf atas perbuatan saya berupa {{ $violation->desc }}
			yang telah melanggar ketentuan Pasal Pasal {{ $violation->regulation_section }} ayat {{ $violation->regulation_letter }}
			Peraturan Rektor Universitas Negeri Gorontalo Nomor {{ $violation->regulation_number }} Tahun {{ $violation->regulation_year }}
			tentang {{ $violation->regulation_about }}
		</p>
		<p style="margin-bottom: 20px; text-align: justify;">Saya berjanji tidak akan mengulangi perbuatan tersebut.</p>
		<p style="margin-bottom: 20px; text-align: justify;">Surat pernyataan ini saya buat dengan sesungguhnya.</p>
	</div>
	<div style="float: right;">
		<div>Gorontalo, {{ \Carbon\Carbon::today()->isoFormat('D MMMM YYYY') }}</div>
		<div style="margin-bottom: 100px">Yang membuat pernyataan,</div>
		<div>{{ $violation->name }}</div>
		<div>NIP. {{ $violation->nip }}</div>
	</div>
@endsection
