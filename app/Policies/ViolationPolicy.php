<?php

namespace App\Policies;

use App\Constants\ViolationStatus;
use App\Models\User;
use App\Models\Violation;

class ViolationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Violation $violation): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isUser();
    }

    public function update(User $user, Violation $violation): bool
    {
        return $user->isAdmin() && $violation->status === ViolationStatus::VERIFIED;
    }

    public function verify(User $user, $violation): bool
    {
        return $user->isAtasan() && $user->atasan->unit_kerja_id === $violation->department;
    }

    public function forward(User $user, $violation): bool
    {
        return $user->isAdmin() && $violation->status === ViolationStatus::VERIFIED;
    }

    public function verdict(User $user, $violation): bool
    {
        return $user->isKomisi() && $violation->status === ViolationStatus::FORWARDED;
    }

    public function provision(User $user, $violation): bool
    {
        return $user->isKomisi() && $violation->status === ViolationStatus::FORWARDED;
    }

    public function examination(User $user, $violation): bool
    {
        return $user->isKomisi();
        // return $user->isKomisi() && $violation->status === ViolationStatus::FORWARDED;
    }
}
