<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 40, 80),
            'calories' => $this->faker->numberBetween(800, 2500),
            'exercise_time' => sprintf('%02d:%02d', $this->faker->numberBetween(0, 2), $this->faker->numberBetween(0, 59)),
            'exercise_content' => $this->faker->randomElement([
                'ウォーキング30分',
                'ジョギング20分',
                'ストレッチ15分',
                '筋トレ30分',
                'ヨガ45分',
                '水泳1時間',
                'サイクリング40分',
                '縄跳び15分',
            ]),
        ];
    }
}
