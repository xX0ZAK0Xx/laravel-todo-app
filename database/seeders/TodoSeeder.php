<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        foreach ($users as $user) {
            // Each user gets 5 todos
            Todo::factory(5)->create([
                'user_id' => $user->id,
            ]);

            // 3 completed todos per user
            Todo::factory(3)->create([
                'user_id'      => $user->id,
                'is_done'      => true,
                'completed_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
