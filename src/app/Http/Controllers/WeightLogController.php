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
        /** @var \App\Models\User $user */
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

    public function show(WeightLog $weightLogId)
    {
        $this->authorize('view', $weightLogId);

        return view('weight_logs.show', ['weightLog' => $weightLogId]);
    }

    public function update(UpdateWeightLogRequest $request, WeightLog $weightLogId)
    {
        $this->authorize('update', $weightLogId);

        $weightLogId->update([
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('weight_logs.index');
    }

    public function destroy(WeightLog $weightLogId)
    {
        $this->authorize('delete', $weightLogId);

        $weightLogId->delete();

        return redirect()->route('weight_logs.index');
    }
}
