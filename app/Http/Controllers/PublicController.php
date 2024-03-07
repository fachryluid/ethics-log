<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreViolationRequest;
use App\Models\Violation;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        return view('pages.public.index');
    }

    public function violation_store(StoreViolationRequest $request)
    {
        try {
            $violation = Violation::create([
                'date' => $request->date,
                'type' => $request->type,
                'offender' => $request->offender,
                'department' => $request->department,
                'desc' => $request->desc,
                'user_id' => auth()->user()->id,
                'evidence' => basename($request->file('evidence')->store('public/uploads/evidences'))
            ]);

            return redirect()->route('dashboard.violations.show', $violation->uuid)->with('success', 'Pengaduan berhasil dibuat.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
