<?php

namespace App\Http\Requests\Auth\App;

use App\Http\Requests\Auth\BaseRegisterRequest;

class RegisterRequest extends BaseRegisterRequest
{
    public function rules(): array
    {
        return array_merge($this->commonRules(), [
            'agreement' => ['accepted'],
        ]);
    }
}
