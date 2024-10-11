<?php

namespace App\Http\Requests\App;

use App\Http\Requests\BaseRegisterRequest;

class RegisterRequest extends BaseRegisterRequest
{
    public function rules(): array
    {
        return array_merge($this->commonRules(), [
            'agreement' => ['accepted'],
        ]);
    }
}
