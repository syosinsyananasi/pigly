<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWeightTargetRequest;
use Illuminate\Support\Facades\Auth;

class WeightTargetController extends Controller
{
    public function edit()
    {
        $weightTarget = Auth::user()->weightTarget;

        return view('weight_logs.goal_setting', compact('weightTarget'));
    }

    public function update(UpdateWeightTargetRequest $request)
    {
        $weightTarget = Auth::user()->weightTarget;

        $weightTarget->update([
            'target_weight' => $request->target_weight,
        ]);

        return redirect()->route('weight_logs.index');
    }
}
