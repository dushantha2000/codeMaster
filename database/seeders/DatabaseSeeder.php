<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Users ලා 50ක් හදනවා
    User::factory(50)->create();

    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    // මේ පේළියේ ඉදිරියෙන් ඇති // ලකුණු අයින් කරන්න
    $this->call(SnippetSeeder::class); 
}
}
