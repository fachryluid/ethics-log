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

  public static function digits($digit, $number)
  {
    // Convert the number to a string
    $numberStr = (string) $number;

    // Calculate the number of zeros to pad
    $zerosToPad = max(0, $digit - strlen($numberStr));

    // Pad the number with leading zeros
    $paddedNumber = str_repeat('0', $zerosToPad) . $numberStr;

    return $paddedNumber;
  }
}
