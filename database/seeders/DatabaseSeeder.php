<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
            ServiceCategoryServiceSeeder::class, // Optional: If using pivot table for services and categories
        ]);
    }
}

