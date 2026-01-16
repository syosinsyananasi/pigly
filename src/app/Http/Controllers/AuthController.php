<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitialWeightRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterStep2()
    {
        return view('auth.register-step2');
    }

    public function storeInitialWeight(InitialWeightRequest $request)
    {
        $user = Auth::user();

        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $request->target_weight,
        ]);

        WeightLog::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'weight' => $request->current_weight,
            'calories' => 0,
            'exercise_time' => '00:00',
            'exercise_content' => '',
        ]);

        return redirect()->route('weight_logs.index');
    }
}
