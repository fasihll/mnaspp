<?php

namespace App\Services;

/**
 * Class UserServices.
 */
class UserServices
{
  public static function toDashboard($user_id)
  {
    return match ($user_id) {
      1 => route('admin.departement'),
      default  => route('student.dashboard'),
    };
  }
}
