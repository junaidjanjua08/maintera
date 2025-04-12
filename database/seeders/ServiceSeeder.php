<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Ceiling Fan Installation', 'category' => 'Electrical'],
            ['name' => 'Switchboard Repair', 'category' => 'Electrical'],
            ['name' => 'Leaky Faucet Fix', 'category' => 'Plumbing'],
            ['name' => 'Drain Cleaning', 'category' => 'Plumbing'],
            ['name' => 'Home Deep Cleaning', 'category' => 'Cleaning'],
            ['name' => 'AC Gas Refilling', 'category' => 'AC Services'],
            ['name' => 'Wall Painting', 'category' => 'Painting'],
            ['name' => 'Door Hinge Repair', 'category' => 'Carpentry'],
            ['name' => 'Washing Machine Repair', 'category' => 'Appliance Repair'],
        ];

        foreach ($services as $service) {
            $category = ServiceCategory::where('name', $service['category'])->first();

            Service::create([
                'name' => $service['name'],
                'description' => $service['name'] . ' description...',
                'category_id' => $category ? $category->id : null,
            ]);
        }
    }
}
