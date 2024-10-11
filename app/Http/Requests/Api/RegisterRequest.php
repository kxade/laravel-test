<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRegisterRequest;

class RegisterRequest extends BaseRegisterRequest
{
    public function rules(): array
    {
        return $this->commonRules();
    }
}

