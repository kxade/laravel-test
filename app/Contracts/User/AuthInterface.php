<?php

namespace App\Contracts\User;

use App\DataTransferObjects\AuthDTO;
use App\Http\Requests\BaseLoginRequest;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function register(AuthDTO $dto, bool $api);

    public function login(BaseLoginRequest $request);

    public function logout(Request $request);
}