@php
	$_USER = App\Constants\UserRole::USER;
	$_ADMIN = App\Constants\UserRole::ADMIN;
	$_MANAGER = App\Constants\UserRole::MANAGER;
	$role = App\Utils\AuthUtils::getRole(auth()->user());
@endphp
@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Pelanggaran' => route('dashboard.reports.violations'),
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
				</div>
				<div class="card-body px-4">
					<table class="table-striped table-detail table">
						<tr>
							<th colspan="2">
								<h6 class="text-uppercase mb-0">Pelapor</h6>
							</th>
						</tr>
						<tr>
							<th>Nama</th>
							<td>{{ App\Utils\FormatUtils::censorName($violation->user->name) }}</td>
						</tr>
						<tr>
							<th>No. HP</th>
							<td>{{ $violation->user->phone }}</td>
						</tr>
						<tr>
							<td colspan="2" class="py-3"></td>
						</tr>
						<tr>
							<th colspan="2">
								<h6 class="text-uppercase mb-0">Terlapor</h6>
							</th>
						</tr>
						<tr>
							<th>Nomor Identitas Pegawai</th>
							<td>
								@if ($violation->nip)
									{{ $violation->nip }}
								@else
									<span class="text-danger fst-italic">Belum dilengkapi</span>
								@endif
							</td>
						</tr>
						<tr>
							<th>Nama Terlapor</th>
							<td>{{ $violation->offender }}</td>
						</tr>
						<tr>
							<th>Pangkat / Golongan</th>
							<td>
								@if ($violation->class)
									{{ $violation->class }}
								@else
									<span class="text-danger fst-italic">Belum dilengkapi</span>
								@endif
							</td>
						</tr>
						<tr>
							<th>Jabatan</th>
							<td>
								@if ($violation->position)
									{{ $violation->position }}
								@else
									<span class="text-danger fst-italic">Belum dilengkapi</span>
								@endif
							</td>
						</tr>
						<tr>
							<th>Unit Kerja</th>
							<td>{{ $violation->unit_kerja->name }}</td>
						</tr>
						<tr>
							<td colspan="2" class="py-3"></td>
						</tr>
						<tr>
							<th colspan="2">
								<h6 class="text-uppercase mb-0">Bentuk Pelanggaran Kode Etik</h6>
							</th>
						</tr>
						<tr>
							<th>Jenis Kode Etik</th>
							<td>{{ $violation->type }}</td>
						</tr>
						<tr>
							<th>Waktu</th>
							<td>{{ $violation->formatted_date }}</td>
						</tr>
						<tr>
							<th>Tempat</th>
							<td>{{ $violation->place }}</td>
						</tr>
						<tr>
							<th>Deskripsi</th>
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
								@php
									$fileUrl = asset('storage/uploads/evidences/' . $violation->evidence);
									$fileExtension = pathinfo($violation->evidence, PATHINFO_EXTENSION);
									$imageExtensions = ['jpeg', 'jpg', 'png', 'gif'];
									$pdfExtensions = ['pdf'];
									$videoExtensions = ['mp4', 'avi', 'mov'];
									$audioExtensions = ['mp3', 'wav'];
								@endphp
								@if (in_array($fileExtension, $imageExtensions))
									<img src="{{ $fileUrl }}" alt="Evidence Image" style="max-width: 100%; height: auto;">
								@elseif (in_array($fileExtension, $pdfExtensions))
									<iframe src="/ViewerJS/#../storage/uploads/evidences/{{ $violation->evidence }}" width="100%" height="500" allowfullscreen webkitallowfullscreen></iframe>
								@elseif (in_array($fileExtension, $videoExtensions))
									<video controls width="100%">
										<source src="{{ $fileUrl }}" type="video/{{ $fileExtension }}">
										Your browser does not support the video tag.
									</video>
								@elseif (in_array($fileExtension, $audioExtensions))
									<audio controls>
										<source src="{{ $fileUrl }}" type="audio/{{ $fileExtension }}">
										Your browser does not support the audio element.
									</audio>
								@else
									<a href="{{ $fileUrl }}">{{ $violation->evidence }}</a>
								@endif
							</td>
						</tr>
						<tr>
							<th>Diverifikasi Pada</th>
							<td>{{ $violation->formatted_verified_at }}</td>
						</tr>
						<tr>
							<td colspan="2" class="py-3"></td>
						</tr>
						<tr>
							<th colspan="2">
								<h6 class="text-uppercase mb-0">
									Ketentuan
								</h6>
							</th>
						</tr>
						<tr>
							<th>Dugaan Pelanggaran Peraturan</th>
							<td>
								Pasal <b>{{ $violation->regulation_section ?? '...' }}</b>
								Ayat <b>{{ $violation->regulation_letter ?? '...' }}</b>
								Peraturan Rektor Universitas Negeri Gorontalo
								Nomor <b>{{ $violation->regulation_number ?? '...' }}</b>
								Tahun <b>{{ $violation->regulation_year ?? '...' }}</b>
								Tentang <b>{{ $violation->regulation_about ?? '...' }}</b>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="py-3"></td>
						</tr>
						<tr>
							<th colspan="2">
								<h6 class="text-uppercase mb-0">
									Pemeriksaan
								</h6>
							</th>
						</tr>
						<tr>
							<th>Tempat</th>
							<td>
								@if (isset($violation->examination_place))
									{{ $violation->examination_place }}
								@else
									<span class="text-danger fst-italic">...</span>
								@endif
							</td>
						</tr>
						<tr>
							<th>Hari, Tanggal</th>
							<td>
								@if (isset($violation->examination_date))
									{{ \Carbon\Carbon::parse($violation->examination_date)->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse($violation->examination_date)->isoFormat('DD MMMM YYYY') }}
								@else
									<span class="text-danger fst-italic">...</span>
								@endif
							</td>
						</tr>
						<tr>
							<th>Waktu</th>
							<td>
								@if (isset($violation->examination_time))
									{{ $violation->examination_time }}
								@else
									<span class="text-danger fst-italic">...</span>
								@endif
							</td>
						</tr>
						<tr>
							<td colspan="2" class="py-3"></td>
						</tr>
						<tr>
							<th colspan="2">
								<h6 class="text-uppercase mb-0">Dokumen</h6>
							</th>
						</tr>
						<tr>
							<th>Berita Acara Pemeriksaaan</th>
							<td>
								@if ($violation->examination_report)
									<iframe src = "/ViewerJS/#../storage/uploads/sessions/{{ $violation->examination_report }}" width='100%' height='500' allowfullscreen webkitallowfullscreen></iframe>
								@endif
							</td>
						</tr>
						@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY)
							<tr>
								<th>Laporan Hasil Pemeriksaan Tentang Dugaan Pelanggaran Kode Etik</th>
								<td>
									@if ($violation->examination_result)
										<iframe src = "/ViewerJS/#../storage/uploads/sessions/{{ $violation->examination_result }}" width='100%' height='500' allowfullscreen webkitallowfullscreen></iframe>
									@endif
								</td>
							</tr>
						@endif
						@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY || $violation->status === App\Constants\ViolationStatus::NOT_PROVEN)
							<tr>
								<th>Putusan Komisi Kode Etik</th>
								<td>
									@if ($violation->session_decision_report)
										<iframe src = "/ViewerJS/#../storage/uploads/sessions/{{ $violation->session_decision_report }}" width='100%' height='500' allowfullscreen webkitallowfullscreen></iframe>
									@endif
								</td>
							</tr>
							@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY)
								<tr>
									<th>Berita Acara Pelaksanaan Putusan Sidang Etik</th>
									<td>
										@if ($violation->session_official_report)
											<iframe src = "/ViewerJS/#../storage/uploads/sessions/{{ $violation->session_official_report }}" width='100%' height='500' allowfullscreen webkitallowfullscreen></iframe>
										@endif
									</td>
								</tr>
							@endif
						@endif
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
