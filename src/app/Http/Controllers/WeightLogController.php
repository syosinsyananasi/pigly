<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWeightLogRequest;
use App\Http\Requests\UpdateWeightLogRequest;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $weightTarget = $user->weightTarget;
        $latestLog = $user->weightLogs()->orderBy('date', 'desc')->first();

        $query = $user->weightLogs()->orderBy('date', 'desc');

        $searchFromDate = $request->input('from_date');
        $searchToDate = $request->input('to_date');
        $isSearching = false;

        if ($searchFromDate && $searchToDate) {
            $query->whereBetween('date', [$searchFromDate, $searchToDate]);
            $isSearching = true;
        }

        $weightLogs = $query->paginate(8);

        if ($isSearching) {
            $weightLogs->appends([
                'from_date' => $searchFromDate,
                'to_date' => $searchToDate,
            ]);
        }

        return view('weight_logs.index', compact(
            'weightTarget',
            'latestLog',
            'weightLogs',
            'searchFromDate',
            'searchToDate',
            'isSearching'
        ));
    }

    public function create()
    {
        return view('weight_logs.create');
    }

    public function store(StoreWeightLogRequest $request)
    {
        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('weight_logs.index');
    }

    public function show(WeightLog $weightLog)
    {
        $this->authorize('view', $weightLog);

        return view('weight_logs.show', compact('weightLog'));
    }

    public function update(UpdateWeightLogRequest $request, WeightLog $weightLog)
    {
        $this->authorize('update', $weightLog);

        $weightLog->update([
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('weight_logs.index');
    }

    public function destroy(WeightLog $weightLog)
    {
        $this->authorize('delete', $weightLog);

        $weightLog->delete();

        return redirect()->route('weight_logs.index');
    }
}
