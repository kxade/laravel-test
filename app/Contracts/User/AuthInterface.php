<?php

namespace App\Contracts\User;

use App\DataTransferObjects\RegisterDTO;

interface AuthInterface
{
    public function register(RegisterDTO $dto);
}