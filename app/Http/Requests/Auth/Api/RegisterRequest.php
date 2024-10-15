<?php

namespace App\Http\Requests\Auth\Api;

use App\Http\Requests\Auth\BaseRegisterRequest;

class RegisterRequest extends BaseRegisterRequest
{
    public function rules(): array
    {
        return $this->commonRules();
    }
}

