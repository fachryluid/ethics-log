<?php

namespace App\Constants;

class ViolationStatus
{
  public const PENDING = 'Pending';
  public const VERIFIED = 'Proses';
  public const SUSPENDED = 'Ditangguhkan';
  public const RESOLVED = 'Diselesaikan';
  public const FORWARDED = 'Diteruskan ke Majelis Etik';
  public const PROVEN_GUILTY = 'Terbukti Bersalah';
  public const NOT_PROVEN = 'Tidak Terbukti';
}
