<?php

namespace App\Http\Controllers;

use App\Constants\ViolationStatus;
use App\Models\User;
use App\Models\Violation;
use App\Utils\FormatUtils;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $violationsQuery = Violation::query();

        $countData = [];

        if (auth()->user()->isAdmin() || auth()->user()->isManager()) {
            $countData['users'] = FormatUtils::digits(3, $users->count());
        }

        if (auth()->user()->isUser()) {
            $countData['users'] = FormatUtils::digits(3, $users->count());
            $violationsQuery->where('user_id', auth()->user()->id);
        }

        if (auth()->user()->isAtasan()) {
            $violationsQuery->where('department', auth()->user()->atasan->unit_kerja_id);
        }

        $violations = $violationsQuery->get();

        $countData['violations'] = FormatUtils::digits(3, $violations->count());
        $countData['pending'] = FormatUtils::digits(3, $violations->where('status', ViolationStatus::PENDING)->count());
        $countData['verified'] = FormatUtils::digits(3, $violations->where('status', ViolationStatus::VERIFIED)->count());
        $countData['forwarded'] = FormatUtils::digits(3, $violations->where('status', ViolationStatus::FORWARDED)->count());
        $countData['proven_guilty'] = FormatUtils::digits(3, $violations->where('status', ViolationStatus::PROVEN_GUILTY)->count());
        $countData['not_proven'] = FormatUtils::digits(3, $violations->where('status', ViolationStatus::NOT_PROVEN)->count());

        $count = (object)($countData);

        return view('pages.dashboard.index', compact('count'));
    }
}
