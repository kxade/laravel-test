<?php

namespace App\DTO;

use App\Http\Requests\Auth\App\RegisterRequest as AppRegisterRequest;
use App\Http\Requests\Auth\Api\RegisterRequest as ApiRegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

readonly class AuthDTO
{
    public function __construct(
        public ?string $name,
        public string $email,
        public string $password,
        public bool $remember = false,
        public bool $agreement = false,
    )
    {
    }

    public static function fromAppRegisterRequest(AppRegisterRequest $request): AuthDTO
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            agreement: $request->validated('agreement') ?? false,
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

    public static function loginRequest(LoginRequest $request): AuthDTO
    {   
        return new self(
            name: null,  // No name for login
            email: $request->validated('email'),
            password: $request->validated('password'),
            remember: $request->validated('remember') ?? false,
        );
    }
}