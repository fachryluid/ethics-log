<?php

namespace App\Http\Controllers;

use App\Constants\UserRole;
use App\Constants\ViolationStatus;
use App\Http\Requests\StoreViolationRequest;
use App\Http\Requests\UpdateViolationRequest;
use App\Models\Violation;
use App\Utils\AuthUtils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ViolationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Violation::query();

            if (AuthUtils::getRole(auth()->user()) == UserRole::USER) {
                $query->where('user_id', auth()->user()->id);
            }

            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('components.badge.violation-status', ['status' => $row->status])->render();
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . route('dashboard.violations.show', $row->uuid) . '" class="btn btn-primary btn-sm">
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
            Violation::create([
                'nip' => $request->nip,
                'date' => $request->date,
                'type' => $request->type,
                'offender' => $request->offender,
                'class' => $request->class,
                'position' => $request->position,
                'department' => $request->department,
                'status' => auth()->user()->isAdmin() ? ViolationStatus::INVESTIGATING : ViolationStatus::PENDING,
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
            $violation->date = $request->date;
            $violation->offender = $request->offender;
            $violation->type = $request->type;
            $violation->desc = $request->desc;
            $violation->status = $request->status;
            $violation->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();

        return redirect()->route('dashboard.violations.index')->with('success', 'Data berhasil dihapus');
    }
}
