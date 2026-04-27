<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a farmer user
        User::factory()->create([
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'role' => 'farmer',
            'email' => 'c',
            'password' => Hash::make('password'),
        ]);

        // Create a developer user
        User::factory()->create([
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'role' => 'developer',
            'email' => 'developer@gulayan.com',
            'password' => Hash::make('password'),
        ]);

        // Create 5 random farmers
        User::factory(5)->create(['role' => 'farmer']);

        // Create 5 random developers
        User::factory(5)->create(['role' => 'developer']);
    }
}
