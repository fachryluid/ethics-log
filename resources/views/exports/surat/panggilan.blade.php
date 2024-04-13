@extends('layouts.surat')
@section('title', 'SURAT PANGGILAN I/II')
@section('content')
	<div style="text-align: center; margin: 30px 0;">RAHASIA</div>
	<div style="text-align: center; margin-bottom: 30px;">
		<div>SURAT PANGGILAN I/II</div>
		<div>Nomor: {{ request('aa') ?? '...' }} / {{ request('bb') ?? '...' }} / {{ request('cc') ?? '...' }} / {{ request('dd') ?? '...' }}</div>
	</div>
	<ol style="margin-bottom: 60px">
		<li>Bersama ini diminta dengan hormat kehadiran Saudara.</li>
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
		<div>Untuk menghadap kepada Majelis Etik pada:</div>
		<table style="margin: 20px 0;">
			<tr>
				<td style="width: 200px">Hari</td>
				<td style="width: 10px">:</td>
				<td>{{ \Carbon\Carbon::parse($violation->examination_date)->isoFormat('dddd') }}</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
				<td>{{ \Carbon\Carbon::parse($violation->examination_date)->isoFormat('DD MMMM YYYY') }}</td>
			</tr>
			<tr>
				<td>Waktu</td>
				<td>:</td>
				<td>{{ $violation->examination_time }}</td>
			</tr>
			<tr>
				<td>Tempat</td>
				<td>:</td>
				<td>{{ $violation->examination_place }}</td>
			</tr>
		</table>
		<div style="margin-bottom: 20px; text-align: justify;">
			Guna diperiksa/dimintai keterangannya sehubungan dengan dugaan
			Pelanggaran Etik dan Perilaku terhadap ketentuan Pasal {{ $violation->regulation_section }} huruf {{ $violation->regulation_letter }}
			Peraturan Menteri Pendidikan dan Kebudayaan Nomor {{ $violation->regulation_number }} Tahun {{ $violation->regulation_year }}
			tentang {{ $violation->regulation_about }} berupa {{ $violation->desc }}
		</div>
		<li>Demikian untuk dilaksanakan.</li>
	</ol>
	<div style="float: right;">
		<div>Gorontalo, {{ \Carbon\Carbon::today()->isoFormat('D MMMM YYYY') }}</div>
		<div style="margin-bottom: 100px">Ketua Majelis Etik,</div>
		<div>Muh. Fachry J.K. Luid, S. Kom</div>
		<div>NIP. 2375412673</div>
	</div>
	<div style="margin-top: 150px">
		<div>Tembusan:</div>
		<ol>
			<li>...</li>
			<li>...</li>
			<li>dst</li>
		</ol>
	</div>
@endsection
