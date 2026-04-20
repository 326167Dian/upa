<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'username' => 'mysifa',
        ], [
            'name' => 'mysifa',
            'role' => 'admin',
            'email' => 'mysifa@example.com',
            'password' => Hash::make('326167Dian&&'),
        ]);

        User::updateOrCreate([
            'username' => 'operatoruser',
        ], [
            'name' => 'Operator User',
            'role' => 'user',
            'email' => 'operatoruser@example.com',
            'password' => Hash::make('326167Dian&&'),
        ]);

        foreach ([
            [
                'name' => 'Budi Santoso',
                'role' => 'admin',
                'phone_number' => '081234567890',
                'full_address' => 'Jl. Melati No. 10, Jakarta Selatan',
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'user',
                'phone_number' => '082345678901',
                'full_address' => 'Jl. Kenanga No. 25, Bandung',
            ],
            [
                'name' => 'Rizky Pratama',
                'role' => 'user',
                'phone_number' => '083456789012',
                'full_address' => 'Jl. Flamboyan No. 8, Surabaya',
            ],
        ] as $operator) {
            Operator::updateOrCreate([
                'name' => $operator['name'],
            ], $operator);
        }
    }
}
