<?php

namespace App\Utils;

class FormatUtils
{
  public static function phoneNumber($phoneNumber)
  {
    if ($phoneNumber) {
      $formattedPhone = substr($phoneNumber, 0, 4) . '-' . substr($phoneNumber, 4, 4) . '-' . substr($phoneNumber, 8, 4);
      return $formattedPhone;
    }
    return null;
  }

  public static function censorName($name)
  {
    if ($name && strlen($name) > 0) {
      // Get the first character of the name
      $firstCharacter = mb_substr($name, 0, 1);

      // Replace all characters in the name except the first one with '*'
      $censoredName = $firstCharacter . str_repeat('*', strlen($name) - 1);
      return $censoredName;
    } else {
      return '-';
    }
  }
}
