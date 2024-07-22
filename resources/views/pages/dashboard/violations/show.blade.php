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
					<h4 class="card-title pl-1">Detail {{ $title }} <br> <small class="fw-normal fs-6">Terakhir kali diedit ({{ $violation->updated_at->diffForHumans() }})</small></h4>
					<div class="d-flex gap-2">
						@if (auth()->user()->isAtasan() && $violation->status === App\Constants\ViolationStatus::PENDING)
							<x-modal.confirm route="{{ route('dashboard.violations.verify', $violation->uuid) }}" method="PATCH" id="verifikasi" title="Verifikasi">
								<x-slot:btn>
									<i class="bi bi-check-circle"></i>
									Verifikasi Dugaan
								</x-slot>
								Verifikasi dugaan <b>Pelanggaran Kode Etik</b> yang dilakukan oleh Dosen/Pegawai atas nama <b>{{ $violation->offender }}</b>.
							</x-modal.confirm>
						@endif
						@if (auth()->user()->isKomisi() && $violation->status === App\Constants\ViolationStatus::FORWARDED)
							<a href="{{ route('dashboard.violations.verdict', $violation->uuid) }}" class="btn btn-primary btn-sm">
								<i class="bi bi-pencil"></i>
								Putusan Sidang
							</a>
						@endif
						@if (auth()->user()->isAdmin() && $violation->status === App\Constants\ViolationStatus::VERIFIED)
							<x-modal.confirm route="{{ route('dashboard.violations.forward', $violation->uuid) }}" method="PATCH" id="forward" title="Teruskan ke Komisi Kode Etik">
								<x-slot:btn>
									<i class="bi bi-fast-forward-circle"></i>
									Teruskan
								</x-slot>
								Data telah terverifikasi. Selanjutnya akan di teruskan ke <b>Komisi Kode Etik</b>.
							</x-modal.confirm>
							<a href="{{ route('dashboard.violations.edit', $violation->uuid) }}" class="btn btn-success btn-sm">
								<i class="bi bi-pencil-square"></i>
								Edit
							</a>
						@endif
						{{-- @if (auth()->user()->isAdmin() || (auth()->user()->isUser() && $violation->status === App\Constants\ViolationStatus::PENDING))
							<x-modal.delete :id="'deleteModal-' . $violation->uuid" :route="route('dashboard.violations.destroy', $violation->uuid)" text="Hapus" />
						@endif --}}
					</div>
				</div>
				<div class="card-body px-4">
					<table class="table-striped table-detail table">
						@if ($role == $_ADMIN)
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
								<td>{{ $violation->user->phone ?? '-' }}</td>
							</tr>
						@endif
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
								<a href="{{ asset('storage/uploads/evidences/' . $violation->evidence) }}">{{ $violation->evidence }}</a>
							</td>
						</tr>
						<tr>
							<th>Diverifikasi Pada</th>
							<td>{{ $violation->formatted_verified_at }}</td>
						</tr>
						@if (auth()->user()->isKomisi() && $violation->status !== App\Constants\ViolationStatus::PENDING)
							<tr>
								<td colspan="2" class="py-3"></td>
							</tr>
							<tr>
								<th colspan="2">
									<h6 class="text-uppercase mb-0">
										Ketentuan
										@can('provision', $violation)
											<a href="{{ route('dashboard.violations.provision', $violation->uuid) }}" class="text-success float-end">
												<i class="bi bi-pencil-square"></i>
												Edit
											</a>
										@endcan
									</h6>
								</th>
							</tr>
							<tr>
								<th>Dugaan Pelanggaran Peraturan</th>
								<td>
									Pasal <b>{{ $violation->regulation_section ?? '...' }}</b>
									Ayat <b>{{ $violation->regulation_letter ?? '...' }}</b>
									Peraturan Rektor Universitas Negeri Gorontalo
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
										@can('examination', $violation)
											<a href="{{ route('dashboard.violations.examination', $violation->uuid) }}" class="text-success float-end">
												<i class="bi bi-pencil-square"></i>
												Edit
											</a>
										@endcan
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
								<th>Surat Pemanggilan</th>
								<td>
									<x-modal.confirm route="{{ route('dashboard.download.surat_panggilan', $violation->uuid) }}" method="GET" id="surat-panggilan" title="Unduh Surat Panggilan" color="success">
										<x-slot:btn>
											<i class="bi bi-download"></i>
											Unduh
										</x-slot>
										<label class="form-label">Nomor Surat</label>
										<div class="row">
											<div class="col-3">
												<input type="text" class="form-control" name="aa" />
											</div>
											<div class="col-3">
												<input type="text" class="form-control" name="bb" />
											</div>
											<div class="col-3">
												<input type="text" class="form-control" name="cc" />
											</div>
											<div class="col-3">
												<input type="text" class="form-control" name="dd" />
											</div>
										</div>
									</x-modal.confirm>
								</td>
							</tr>
							<tr>
								<th>Berita Acara Pemeriksaaan</th>
								<td>
									<a href="{{ $violation->examination_report ? asset('storage/uploads/sessions/' . $violation->examination_report) : 'javascript::void' }}" class="btn btn-success btn-sm @if (!$violation->examination_report) opacity-50 @endif">
										<i class="bi bi-download"></i>
										Unduh
									</a>
								</td>
							</tr>
							@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY)
								<tr>
									<th>Laporan Hasil Pemeriksaan Tentang Dugaan Pelanggaran Kode Etik</th>
									<td>
										<a href="{{ $violation->examination_result ? asset('storage/uploads/sessions/' . $violation->examination_result) : 'javascript::void' }}" class="btn btn-success btn-sm @if (!$violation->examination_result) opacity-50 @endif">
											<i class="bi bi-download"></i>
											Unduh
										</a>
									</td>
								</tr>
							@endif
							@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY || $violation->status === App\Constants\ViolationStatus::NOT_PROVEN)
								<tr>
									<th>Putusan Komisi Kode Etik</th>
									<td>
										<a href="{{ asset('storage/uploads/sessions/' . $violation->session_decision_report) }}" class="btn btn-success btn-sm">
											<i class="bi bi-download"></i>
											Unduh
										</a>
									</td>
								</tr>
								@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY)
									<tr>
										<th>Berita Acara Pelaksanaan Putusan Sidang Etik</th>
										<td>
											<a href="{{ asset('storage/uploads/sessions/' . $violation->session_official_report) }}" class="btn btn-success btn-sm">
												<i class="bi bi-download"></i>
												Unduh
											</a>
										</td>
									</tr>
								@endif
							@endif
							@if ($violation->status === App\Constants\ViolationStatus::PROVEN_GUILTY)
								<tr>
									<th>Surat Pernyataan Permohonan Maaf</th>
									<td>
										<x-modal.confirm route="{{ route('dashboard.download.surat_permohonan_maaf', $violation->uuid) }}" method="GET" id="surat-permohonan-maaf" title="Unduh Surat Permohonan Maaf" color="success">
											<x-slot:btn>
												<i class="bi bi-download"></i>
												Unduh
											</x-slot>
											<label class="form-label">Nomor Surat</label>
											<div class="row">
												<div class="col-3">
													<input type="text" class="form-control" name="aa" />
												</div>
												<div class="col-3">
													<input type="text" class="form-control" name="bb" />
												</div>
												<div class="col-3">
													<input type="text" class="form-control" name="cc" />
												</div>
												<div class="col-3">
													<input type="text" class="form-control" name="dd" />
												</div>
											</div>
										</x-modal.confirm>
									</td>
								</tr>
								<tr>
									<th>Surat Pernyataan Penyesalan</th>
									<td>
										<x-modal.confirm route="{{ route('dashboard.download.surat_penyesalan', $violation->uuid) }}" method="GET" id="surat-penyesalan" title="Unduh Surat Penyesalan" color="success">
											<x-slot:btn>
												<i class="bi bi-download"></i>
												Unduh
											</x-slot>
											<label class="form-label">Nomor Surat</label>
											<div class="row">
												<div class="col-3">
													<input type="text" class="form-control" name="aa" />
												</div>
												<div class="col-3">
													<input type="text" class="form-control" name="bb" />
												</div>
												<div class="col-3">
													<input type="text" class="form-control" name="cc" />
												</div>
												<div class="col-3">
													<input type="text" class="form-control" name="dd" />
												</div>
											</div>
										</x-modal.confirm>
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
