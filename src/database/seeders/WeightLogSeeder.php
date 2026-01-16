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
            WeightLog::create([
                'user_id' => $user->id,
                'date' => $baseDate->copy()->subDays($i)->format('Y-m-d'),
                'weight' => round(46.0 + (rand(-10, 10) / 10), 1),
                'calories' => rand(1000, 2000),
                'exercise_time' => sprintf('%02d:%02d', rand(0, 1), rand(0, 59)),
                'exercise_content' => collect([
                    'ウォーキング30分',
                    'ジョギング20分',
                    'ストレッチ15分',
                    '筋トレ30分',
                    'ヨガ45分',
                    '水泳1時間',
                    'サイクリング40分',
                    '縄跳び15分',
                ])->random(),
            ]);
        }
    }
}
