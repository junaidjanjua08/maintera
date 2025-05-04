<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


    
    class OrdersTableSeeder extends Seeder
    {
        public function run(): void
        {
            $statuses = [
                'pending', 'offer_received', 'accepted', 'in_progress', 
                'completed', 'cancelled', 'pending', 'accepted', 
                'in_progress', 'completed'
            ];
    
            foreach (range(1, 10) as $i) {
                DB::table('orders')->insert([
                    'user_id' => rand(1, 5),               // Assumes users with IDs 1–5 exist
                    'category_id' => rand(1, 3),           // Assumes categories with IDs 1–3 exist
                    'subcategory_id' => rand(1, 5),        // Assumes subcategories with IDs 1–5 exist
                    'description' => fake()->sentence(),
                    'street_address' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'area' => fake()->word(),
                    'sub_area' => fake()->word(),
                    'latitude' => fake()->latitude(),
                    'longitude' => fake()->longitude(),
                    'payment_mode' => fake()->randomElement(['cash', 'online']),
                    'scheduled_at' => Carbon::now()->addDays(rand(1, 10)),
                    'status' => $statuses[$i - 1],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    

