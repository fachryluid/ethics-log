<?php

namespace App\Http\Controllers;

use App\Constants\UserRole;
use App\Constants\ViolationStatus;
use App\Http\Requests\StoreViolationRequest;
use App\Http\Requests\UpdateExaminationRequest;
use App\Http\Requests\UpdateProvisionRequest;
use App\Http\Requests\UpdateVerdictRequest;
use App\Http\Requests\UpdateViolationRequest;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\Violation;
use App\Utils\AuthUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ViolationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Violation::class, 'violation');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Violation::query();

            if (AuthUtils::getRole(auth()->user()) == UserRole::USER) {
                $query->where('user_id', auth()->user()->id);
            }

            if (auth()->user()->isAtasan()) {
                $query->where('department', auth()->user()->atasan->unit_kerja_id);
            }

            $status = $request->input('status');

            if ($status) {
                $query->where('status', $status);
            }

            $data = $query->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('components.badge.violation-status', ['status' => $row->status])->render();
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . route('dashboard.violations.show', $row->uuid) . '" class="btn btn-primary btn-sm" style="white-space: nowrap;">
                            <i class="bi bi-list-ul"></i>
                            Detail
                        </a> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('pages.dashboard.violations.index');
    }

    public function create(Request $request)
    {
        $units = UnitKerja::all();
        $pegawais = Pegawai::all();
        $selectedPegawai = null;

        if ($request->has('nip')) {
            $selectedPegawai = Pegawai::where('nip', $request->nip)->first();

            if ($selectedPegawai) {
                $unitKerja = UnitKerja::where('name', $selectedPegawai->department)->first();
                $selectedPegawai->unitKerjaId = $unitKerja ? $unitKerja->id : null;
            }
        }

        return view('pages.dashboard.violations.create', compact('pegawais', 'selectedPegawai', 'units'));
    }

    public function store(StoreViolationRequest $request)
    {
        try {
            $violation = Violation::create($request->only(
                [
                    'nip',
                    'date',
                    'place',
                    'type',
                    'offender',
                    'class',
                    'position',
                    'department',
                    'regulation_section',
                    'regulation_letter',
                    'regulation_number',
                    'regulation_year',
                    'regulation_about',
                ]
            ) + [
                'status' => auth()->user()->isAdmin() ? ViolationStatus::VERIFIED : ViolationStatus::PENDING,
                'user_id' => auth()->user()->id,
                'desc' => $request->desc,
                'evidence' => basename($request->file('evidence')->store('public/uploads/evidences'))
            ]);

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function show(Violation $violation)
    {
        return view('pages.dashboard.violations.show', compact('violation'));
    }

    public function edit(Request $request, Violation $violation)
    {
        $pegawais = Pegawai::all();
        $selectedPegawai = null;

        if ($request->has('nip')) {
            $selectedPegawai = Pegawai::where('nip', $request->nip)->first();

            if ($selectedPegawai) {
                $unitKerja = UnitKerja::where('name', $selectedPegawai->department)->first();
                $selectedPegawai->unitKerjaId = $unitKerja ? $unitKerja->id : null;
            }
        }

        return view('pages.dashboard.violations.edit', compact('violation', 'pegawais', 'selectedPegawai'));
    }

    public function update(UpdateViolationRequest $request, Violation $violation)
    {
        try {
            // if ($request->hasFile('evidence')) {
            //     Storage::delete('public/uploads/evidences/' . $violation->evidence);
            //     $violation->evidence = basename($request->file('evidence')->store('public/uploads/evidences'));
            // }

            $violation->nip = $request->nip;
            $violation->offender = $request->offender;
            $violation->class = $request->class;
            $violation->position = $request->position;
            $violation->department = $request->department;
            // $violation->type = $request->type;
            // $violation->date = $request->date;
            // $violation->place = $request->place;
            // $violation->desc = $request->desc;

            $violation->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function destroy(Violation $violation)
    {
        try {
            if ($violation->status != ViolationStatus::PENDING) {
                throw new \Error('Tidak dapat menghapus data. Ini mungkin terjadi karena data telah berubah sebelumnya.');
            }

            $violation->delete();

            return redirect()->route('dashboard.violations.index')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function verify(Violation $violation)
    {
        try {
            $violation->status = ViolationStatus::VERIFIED;
            $violation->verified_at = Carbon::now();
            $violation->save();

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Data telah terverifikasi');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function forward(Violation $violation)
    {
        try {
            $validator = Validator::make($violation->toArray(), [
                'nip' => 'required',
                'class' => 'required',
                'position' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors('Data belum lengkap. Silakan lengkapi data terlebih dahulu!')->withInput();
            }

            $violation->status = ViolationStatus::FORWARDED;
            $violation->save();

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Data telah diteruskan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function verdict(Violation $violation)
    {
        return view('pages.dashboard.violations.verdict', compact('violation'));
    }

    public function verdict_update(UpdateVerdictRequest $request, Violation $violation)
    {
        try {
            $violation->session_date = $request->session_date;
            $violation->session_decision_report = basename($request->file('session_decision_report')->store('public/uploads/sessions'));
            if ($request->hasFile('session_official_report')) {
                $sessionOfficialReportPath = $request->file('session_official_report')->store('public/uploads/sessions');
                $violation->session_official_report = basename($sessionOfficialReportPath);
            }
            $violation->status = $request->status;
            $violation->save();

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Putusan sidang telah diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function provision(Violation $violation)
    {
        return view('pages.dashboard.violations.provision', compact('violation'));
    }

    public function provision_update(UpdateProvisionRequest $request, Violation $violation)
    {
        try {
            $violation->regulation_section = $request->regulation_section;
            $violation->regulation_letter = $request->regulation_letter;
            $violation->regulation_number = "199/UN47/KP/2020";
            $violation->regulation_year = "2020";
            $violation->regulation_about = "Kode Etik Pegawai Negeri Sipil di Lingkungan Universitas Negeri Gorontalo";
            $violation->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function examination(Violation $violation)
    {
        return view('pages.dashboard.violations.examination', compact('violation'));
    }

    public function examination_update(UpdateExaminationRequest $request, Violation $violation)
    {
        try {
            $violation->examination_place = $request->examination_place;
            $violation->examination_date = $request->examination_date;
            $violation->examination_time = $request->examination_time;

            if ($request->hasFile('examination_report')) {
                $violation->examination_report = basename($request->file('examination_report')->store('public/uploads/sessions'));
            }

            if ($request->hasFile('examination_result')) {
                $violation->examination_result = basename($request->file('examination_result')->store('public/uploads/sessions'));
            }

            $violation->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
