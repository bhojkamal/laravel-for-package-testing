<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Base\Repository;
use App\Repositories\Auth\Interfaces\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
  /**
   * Specify Model class name.
   *
   * @return string
   */
  public function model(): string
  {
    return User::class;
  }
}
