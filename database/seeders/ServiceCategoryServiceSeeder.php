<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceCategoryServiceSeeder extends Seeder
{
    public function run()
    {
        // Here you can manually link services to categories if using a pivot table
        $serviceCategoryServiceData = [
            // For example: Ceiling Fan Installation (Service ID 1) linked to Electrical (Category ID 1)
            ['service_id' => 1, 'service_category_id' => 1],
            ['service_id' => 2, 'service_category_id' => 1],
            ['service_id' => 3, 'service_category_id' => 2],
            ['service_id' => 4, 'service_category_id' => 2],
            // Add more relations as required
        ];

        foreach ($serviceCategoryServiceData as $data) {
            \DB::table('service_category_service')->insert($data);
        }
    }
}
