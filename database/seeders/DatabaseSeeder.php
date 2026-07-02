<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for truncation (optional, if we want to run multiple times cleanly)
        Schema::disableForeignKeyConstraints();

        $tables = [
            'users',
            'tokos',
            'produks',
            'carts',
            'cart_items',
            'orders',
            'order_items',
            'payments',
            'toko_daily_summaries',
            'platform_daily_summaries',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();

        // Run the seeders in the correct order based on constraints
        $this->call([
            UserSeeder::class,
            TokoSeeder::class,
            ProdukSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
