<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if (!$user->weightTarget) {
            return redirect()->route('register.step2');
        }

        return redirect()->route('weight_logs.index');
    }
}
