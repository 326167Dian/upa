<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
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
        $adminUser = User::updateOrCreate([
            'username' => 'mysifa',
        ], [
            'name' => 'mysifa',
            'role' => 'admin',
            'email' => 'mysifa@example.com',
            'password' => Hash::make('326167Dian&&'),
        ]);

        $userAccount = User::updateOrCreate([
            'username' => 'operatoruser',
        ], [
            'name' => 'Operator User',
            'role' => 'user',
            'email' => 'operatoruser@example.com',
            'password' => Hash::make('326167Dian&&'),
        ]);

        $adminOperator = Operator::updateOrCreate([
            'user_id' => $adminUser->id,
        ], [
            'name' => 'mysifa',
            'role' => 'admin',
            'phone_number' => '081200000001',
            'full_address' => 'Jl. Admin Utama No. 1, Jakarta',
        ]);

        $userOperator = Operator::updateOrCreate([
            'user_id' => $userAccount->id,
        ], [
            'name' => 'Operator User',
            'role' => 'user',
            'phone_number' => '081200000002',
            'full_address' => 'Jl. Operator User No. 2, Bandung',
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
                'user_id' => null,
                'name' => $operator['name'],
            ], $operator);
        }

        foreach ([
            [
                'nama_kegiatan' => 'Persiapan Laporan Bulanan',
                'deskripsi' => '<p>Menyusun <strong>laporan bulanan</strong> dan memeriksa data operator aktif.</p>',
                'id' => $adminOperator->id,
            ],
            [
                'nama_kegiatan' => 'Validasi Data Lapangan',
                'deskripsi' => '<p>Melakukan validasi data alamat dan nomor telepon operator di wilayah Bandung.</p>',
                'id' => $userOperator->id,
            ],
        ] as $kegiatan) {
            Kegiatan::updateOrCreate([
                'nama_kegiatan' => $kegiatan['nama_kegiatan'],
            ], $kegiatan);
        }
    }
}
