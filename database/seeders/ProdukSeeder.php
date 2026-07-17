<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Create Categories first
        $categories = [
            ['id' => 1, 'name' => 'Elektronik', 'slug' => 'elektronik', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Fashion', 'slug' => 'fashion', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Kuliner', 'slug' => 'kuliner', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('categories')->insert($categories);

        $produks = [];
        $idCounter = 1;

        // Toko 1: Elektronik (17 products)
        $elektronik = [
            'Lampu LED 10W Hemat Energi', 'Kipas Angin Meja 12 Inch', 'Kabel Data Type-C Fast Charging', 
            'Powerbank 10000mAh', 'Headset Bluetooth TWS', 'Mouse Wireless Ergonomis', 'Keyboard Mechanical RGB', 
            'Flashdisk 64GB', 'MicroSD 128GB Class 10', 'Speaker Bluetooth Mini', 'Adaptor Charger 20W', 
            'Kabel HDMI 2 Meter', 'Webcam 1080p HD', 'Stand Holder HP', 'Casing HP Transparan', 
            'Tempered Glass Layar', 'Lampu Tidur Karakter'
        ];
        
        foreach ($elektronik as $nama) {
            $hargaJual = rand(15, 250) * 1000;
            $produks[] = [
                'id' => $idCounter++,
                'toko_id' => 1,
                'category_id' => 1,
                'nama_produk' => $nama,
                'deskripsi' => 'Deskripsi untuk ' . $nama . ' dengan kualitas terbaik dan garansi terjamin.',
                'harga_pokok' => $hargaJual * 0.7, // 30% margin
                'harga' => $hargaJual,
                'berat' => rand(100, 2000),
                'stok' => rand(10, 100),
                'gambar' => 'default_produk.jpg',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Toko 2: Fashion (17 products)
        $fashion = [
            'Hijab Bergo Maryam Instan', 'Pashmina Ceruty Babydoll', 'Gamis Syari Motif Bunga', 
            'Tunik Katun Rayon', 'Atasan Blouse Wanita Korea', 'Celana Kulot Highwaist', 'Rok Plisket Premium', 
            'Mukena Bali Adem', 'Manset Tangan Rajut', 'Ciput Rajut Anti Pusing', 'Bros Hijab Cantik', 
            'Kemeja Flanel Wanita', 'Sweater Oversize', 'Jaket Denim Crop', 'Kaos Kaki Motif Lucu', 
            'Sandal Slop Wanita', 'Tas Selempang Mini'
        ];

        foreach ($fashion as $nama) {
            $hargaJual = rand(25, 150) * 1000;
            $produks[] = [
                'id' => $idCounter++,
                'toko_id' => 2,
                'category_id' => 2,
                'nama_produk' => $nama,
                'deskripsi' => 'Deskripsi untuk ' . $nama . '. Bahan nyaman dipakai seharian, cocok untuk gaya kasual.',
                'harga_pokok' => $hargaJual * 0.6, // 40% margin
                'harga' => $hargaJual,
                'berat' => rand(200, 800),
                'stok' => rand(20, 200),
                'gambar' => 'default_produk.jpg',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Toko 3: Kuliner (16 products)
        $kuliner = [
            'Keripik Tempe Renyah 200gr', 'Keripik Pisang Coklat Lumer', 'Sambal Bawang Botolan', 
            'Kopi Bubuk Robusta Dampit', 'Teh Tarik Instan Sachet', 'Dodol Garut Asli', 'Bakpia Pathok Isi Kacang Hijau', 
            'Kerupuk Seblak Bantat Pedas', 'Basreng Daun Jeruk', 'Makaroni Ngehe Balado', 'Kue Kering Nastar', 
            'Kue Putri Salju', 'Abon Sapi Asli Spesial', 'Kacang Mede Oven Panggang', 'Madu Hutan Asli Murni', 
            'Rengginang Lorjuk Madura'
        ];

        foreach ($kuliner as $nama) {
            $hargaJual = rand(10, 80) * 1000;
            $produks[] = [
                'id' => $idCounter++,
                'toko_id' => 3,
                'category_id' => 3,
                'nama_produk' => $nama,
                'deskripsi' => 'Deskripsi untuk ' . $nama . '. Dibuat dari bahan pilihan, rasanya dijamin nagih!',
                'harga_pokok' => $hargaJual * 0.5, // 50% margin
                'harga' => $hargaJual,
                'berat' => rand(100, 500),
                'stok' => rand(30, 300),
                'gambar' => 'default_produk.jpg',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('produks')->insert($produks);
    }
}
