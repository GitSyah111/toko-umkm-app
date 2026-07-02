<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $password = Hash::make('password123');

        $users = [];

        // 3 Sellers
        $sellers = ['Budi Santoso', 'Siti Aminah', 'Agus Prayitno'];
        foreach ($sellers as $index => $name) {
            $users[] = [
                'id' => $index + 1,
                'name' => $name,
                'email' => strtolower(explode(' ', $name)[0]) . '@seller.com',
                'password' => $password,
                'role' => 'seller',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 10 Buyers
        $buyers = [
            'Rina Wijaya', 'Dewi Lestari', 'Joko Susanto', 'Hendra Gunawan', 'Maya Sari',
            'Irfan Hakim', 'Nina Kartika', 'Rizky Ramadhan', 'Putri Diana', 'Ahmad Fauzi'
        ];
        foreach ($buyers as $index => $name) {
            $users[] = [
                'id' => $index + 4,
                'name' => $name,
                'email' => strtolower(explode(' ', $name)[0]) . '@buyer.com',
                'password' => $password,
                'role' => 'buyer',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('users')->insert($users);
    }
}
