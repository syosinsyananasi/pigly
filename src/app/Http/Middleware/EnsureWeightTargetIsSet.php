<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureWeightTargetIsSet
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $isStep2Route = $request->routeIs('register.step2') || $request->routeIs('register.step2.store');

            if (!$user->weightTarget && !$isStep2Route) {
                return redirect()->route('register.step2');
            }

            if ($user->weightTarget && $isStep2Route) {
                return redirect()->route('weight_logs.index');
            }
        }

        return $next($request);
    }
}
