<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
}
