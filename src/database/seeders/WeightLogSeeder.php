<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeightLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeightLogSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $baseDate = Carbon::now();

        for ($i = 0; $i < 35; $i++) {
            WeightLog::factory()->create([
                'user_id' => $user->id,
                'date' => $baseDate->copy()->subDays($i)->format('Y-m-d'),
            ]);
        }
    }
}
