<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeightTarget;
use Illuminate\Database\Seeder;

class WeightTargetSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => 45.0,
        ]);
    }
}
