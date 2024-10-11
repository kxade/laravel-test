<?php

namespace App\DataTransferObjects;

use App\Http\Requests\App\RegisterRequest as AppRegisterRequest;
use App\Http\Requests\Api\RegisterRequest as ApiRegisterRequest;

readonly class AuthDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    )
    {
    }

    public static function fromAppRegisterRequest(AppRegisterRequest $request): AuthDTO
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }

    public static function fromApiRegisterRequest(ApiRegisterRequest $request): AuthDTO
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }

}