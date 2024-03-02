<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreViolationRequest;
use App\Http\Requests\UpdateViolationRequest;
use App\Models\Violation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ViolationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Violation::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . route('dashboard.violations.show', $row->uuid) . '" class="btn btn-primary btn-sm">
                            <i class="bi bi-list-ul"></i>
                            Detail
                        </a> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
            Violation::create($request->all());

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
