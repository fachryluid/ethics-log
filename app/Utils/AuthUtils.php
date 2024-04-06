<?php

namespace App\Utils;

use App\Constants\UserRole;

class AuthUtils
{
    public static function getRole($user)
    {
        if ($user->admin) {
          $role = UserRole::ADMIN;
        }

        if ($user->manager) {
          $role = UserRole::MANAGER;
        }

        if ($user->atasan) {
          $role = UserRole::ATASAN_UNIT_KERJA;
        }

        if ($user->komisi) {
          $role = UserRole::KOMISI_KODE_ETIK;
        }

        return $role ?? UserRole::USER;
    }
}
