<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create()->each(function ($user) {
            \App\Models\Transaction::factory(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
