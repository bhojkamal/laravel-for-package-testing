<?php

use App\Repositories\Auth\Interfaces\UserRepositoryInterface;
use App\Repositories\Auth\UserRepository;

return [
  UserRepositoryInterface::class => UserRepository::class,
];
