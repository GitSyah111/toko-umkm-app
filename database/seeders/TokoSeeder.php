<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $tokos = [
            [
                'id' => 1,
                'user_id' => 1, // Budi Santoso
                'nama_toko' => 'Budi Jaya Elektronik',
                'deskripsi' => 'Menjual berbagai macam barang elektronik murah dan berkualitas.',
                'alamat' => 'Jl. Kebon Jeruk No. 15, Jakarta Barat',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 2, // Siti Aminah
                'nama_toko' => 'Siti Fashion & Hijab',
                'deskripsi' => 'Pusat busana muslim dan hijab kekinian produksi lokal.',
                'alamat' => 'Pasar Tanah Abang Blok B, Jakarta Pusat',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 3, // Agus Prayitno
                'nama_toko' => 'Agus Kuliner Nusantara',
                'deskripsi' => 'Oleh-oleh khas daerah dan camilan tradisional Indonesia.',
                'alamat' => 'Jl. Malioboro No. 45, Yogyakarta',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tokos')->insert($tokos);
    }
}
