<?php

namespace App\Http\Controllers;

use App\Constants\UserRole;
use App\Constants\ViolationStatus;
use App\Http\Requests\StoreViolationRequest;
use App\Http\Requests\UpdateVerdictRequest;
use App\Http\Requests\UpdateViolationRequest;
use App\Models\Violation;
use App\Utils\AuthUtils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Violation::query();

            if (AuthUtils::getRole(auth()->user()) == UserRole::USER) {
                $query->where('user_id', auth()->user()->id);
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

    public function create()
    {
        return view('pages.dashboard.violations.create');
    }

    public function store(StoreViolationRequest $request)
    {
        try {
            Violation::create($request->only(
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

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function show(Violation $violation)
    {
        return view('pages.dashboard.violations.show', compact('violation'));
    }

    public function edit(Violation $violation)
    {
        if (AuthUtils::getRole(auth()->user()) == UserRole::USER) {
            return redirect()->back()->withErrors('Akses tidak sah.');
        }

        return view('pages.dashboard.violations.edit', compact('violation'));
    }

    public function update(UpdateViolationRequest $request, Violation $violation)
    {
        try {
            if ($request->hasFile('evidence')) {
                Storage::delete('public/uploads/evidences/' . $violation->evidence);
                $violation->evidence = basename($request->file('evidence')->store('public/uploads/evidences'));
            }

            $violation->nip = $request->nip;
            $violation->offender = $request->offender;
            $violation->class = $request->class;
            $violation->position = $request->position;
            $violation->department = $request->department;
            $violation->type = $request->type;
            $violation->regulation_section = $request->regulation_section;
            $violation->regulation_letter = $request->regulation_letter;
            $violation->regulation_number = $request->regulation_number;
            $violation->regulation_year = $request->regulation_year;
            $violation->regulation_about = $request->regulation_about;
            $violation->date = $request->date;
            $violation->place = $request->place;
            $violation->desc = $request->desc;

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
            if (!$violation->nip || !$violation->class || !$violation->position) {
                throw new \Error('Verifikasi data gagal, lengkapi data terlebih dahulu.');
            }

            $violation->status = ViolationStatus::VERIFIED;
            $violation->save();

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Data telah terverifikasi');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function forward(Violation $violation)
    {
        try {
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
            $violation->session_official_report = basename($request->file('session_official_report')->store('public/uploads/sessions'));
            $violation->status = $request->status;
            $violation->save();

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Putusan sidang telah diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
