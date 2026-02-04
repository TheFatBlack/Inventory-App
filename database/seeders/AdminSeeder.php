<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Andika',
            'username' => 'Konjiro',
            'email' => 'Andika@Rpl.com', 
            'password' => Hash::make('Andika1'),
            'no_hp' => '082275570763',
            'nip' => '1234567890',
            'role' => 'admin',
        ]);
    }
}
