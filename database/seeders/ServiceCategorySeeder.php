<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electrical', 'slug' => 'electrical'],
            ['name' => 'Plumbing', 'slug' => 'plumbing'],
            ['name' => 'Cleaning', 'slug' => 'cleaning'],
            ['name' => 'AC Services', 'slug' => 'ac-services'],
            ['name' => 'Carpentry', 'slug' => 'carpentry'],
            ['name' => 'Appliance Repair', 'slug' => 'appliance-repair'],
            ['name' => 'Painting', 'slug' => 'painting'],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
