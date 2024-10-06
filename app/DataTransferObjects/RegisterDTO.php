<?php

namespace App\DataTransferObjects;

use App\Http\Requests\App\RegisterRequest;

readonly class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password, 
        public bool $agreement
    )
    {
    }

    public static function fromAppRequest(RegisterRequest $request): RegisterDTO
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            agreement: $request->validated('agreement'),
        );
    }

}