<?php

namespace Database\Seeders;

use App\Models\GameSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSessionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // 3–8 games per user, random scores
            for ($i = 0; $i < rand(3, 8); $i++) {
                GameSession::create([
                    'user_id'       => $user->id,
                    'score'         => rand(30, 150),   // e.g. 10 points per correct → max 150
                    'correct_count' => rand(3, 15),
                    'started_at'    => now()->subDays(rand(1, 60)),
                    'finished_at'   => now()->subDays(rand(1, 60))->addMinutes(rand(5, 45)),
                ]);
            }
        }

        $this->command->info('Fake game sessions seeded for leaderboard testing.');
    }
}