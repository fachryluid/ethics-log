<?php

namespace App\Http\Controllers;

use App\Constants\ViolationStatus;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Violation;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function users(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();

            $type = $request->input('type');

            if (isset($type)) {
                if ($type === 'pelapor') {
                    $data->whereDoesntHave('atasan');
                    $data->whereDoesntHave('komisi');
                    $data->whereDoesntHave('admin');
                    $data->whereDoesntHave('manager');
                } else {
                    $data->whereHas($type);
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.dashboard.reports.users');
    }

    public function users_pdf_preview(Request $request)
    {
        $users = User::all();

        $Pdf = Pdf::loadView('exports.users', compact('users'));

        return $Pdf->stream();
    }

    public function violations(Request $request)
    {
        if ($request->ajax()) {
            $data = Violation::query();
            if ($request->has('status')) $data->where('status', $request->status);
            $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . route('dashboard.reports.violations.show', $row->uuid) . '" class="btn btn-primary btn-sm" style="white-space: nowrap">
                            <i class="bi bi-list-ul"></i>
                            Detail
                        </a> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.dashboard.reports.violations');
    }

    public function violations_show(Violation $violation)
    {
        return view('pages.dashboard.reports.violations-detail', compact('violation'));
    }

    public function violations_pdf_preview(Request $request)
    {
        $violations = Violation::where('status', ViolationStatus::PROVEN_GUILTY)->orWhere('status', ViolationStatus::NOT_PROVEN)->get();

        $Pdf = Pdf::loadView('exports.violations', compact('violations'));

        return $Pdf->stream();
    }
}
