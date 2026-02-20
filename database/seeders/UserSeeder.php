<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $organization = Organization::create([
            'name' => 'default',
            'slug' => 'default',
        ]);

        $user = User::create([
            'name' => 'Andreas',
            'email' => 'ag@a14r.de',
            'password' => bcrypt('123'),
        ]);

        $user->organizations()->attach($organization, ['role' => 'admin2']);
    }
}
