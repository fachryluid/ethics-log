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

        if (auth()->user()->isAdmin()) {
            $countData['users'] = FormatUtils::digits(3, $users->count());
        }

        if (auth()->user()->isUser()) {
            $countData['users'] = FormatUtils::digits(3, $users->count());
            $violationsQuery->where('user_id', auth()->user()->id);
        }

        $violations = $violationsQuery->get();

        $countData['violations'] = FormatUtils::digits(3, $violations->count());
        $countData['pending'] = $violations->where('status', ViolationStatus::PENDING)->count();
        $countData['verified'] = $violations->where('status', ViolationStatus::VERIFIED)->count();
        $countData['forwarded'] = $violations->where('status', ViolationStatus::FORWARDED)->count();
        $countData['proven_guilty'] = $violations->where('status', ViolationStatus::PROVEN_GUILTY)->count();
        $countData['not_proven'] = $violations->where('status', ViolationStatus::NOT_PROVEN)->count();

        $count = (object)($countData);

        return view('pages.dashboard.index', compact('count'));
    }
}
