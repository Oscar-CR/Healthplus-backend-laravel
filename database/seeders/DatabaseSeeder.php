<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DailyAdvance;
use App\Models\DalyAdvance;
use App\Models\Disease;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'administrador', // optional
            'description' => '', // optional
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'usuario', // optional
            'description' => '', // optional
        ]);

        
        User::create([
            'name' => 'Brandon',
            'lastname' => 'Torres Iriarte',
            'age' => 23,
            'email' =>'brandon@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
        ])->attachRole($admin); 
        
        User::create([
            'name' => 'David',
            'lastname' => 'Navarrete Cordero',
            'age' => 22,
            'email' =>'david@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
        ])->attachRole($user);

        Disease::create([
            'name' => 'Alcoholismo',
            'description' => 'alcoholismo'
        ]);

        Disease::create([
            'name' => 'Tabaquismo',
            'description' => 'tabaquismo'
        ]);

        Disease::create([
            'name' => 'Tabaquismo',
            'description' => 'tabaquismo'
        ]);

        DailyAdvance::create([
            'total_consumed' => 2,
            'details' => 'Sensacion de ansiedad',
            'disease_id' => 1,
            'user_id' => 2,
        ]);

        DailyAdvance::create([
            'total_consumed' => 4,
            'details' => 'Dificultad para dormir',
            'disease_id' => 1,
            'user_id' => 2,
        ]);

        DailyAdvance::create([
            'total_consumed' => 3,
            'details' => 'Ansiedad',
            'disease_id' => 1,
            'user_id' => 2,
        ]);

        DailyAdvance::create([
            'total_consumed' => 1,
            'details' => 'Cansancio',
            'disease_id' => 1,
            'user_id' => 2,
        ]);

    }
}
