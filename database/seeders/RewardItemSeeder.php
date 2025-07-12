<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;

class RewardItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Beras 5 Kg',
                'point_cost' => 250,
                'stock' => 20,
                'image' => 'products/beras.jpg',
            ],
            [
                'name' => 'Minyak Goreng 2L',
                'point_cost' => 180,
                'stock' => 15,
                'image' => 'products/minyak.jpg',
            ],
            [
                'name' => 'Gula 1 Kg',
                'point_cost' => 100,
                'stock' => 25,
                'image' => 'products/gula.jpg',
            ],
            [
                'name' => 'Mie Instan 1 dus',
                'point_cost' => 200,
                'stock' => 10,
                'image' => 'products/mie.jpg',
            ],
            [
                'name' => 'Susu Bubuk 400g',
                'point_cost' => 150,
                'stock' => 12,
                'image' => 'products/susu.jpg',
            ],
        ];

        foreach ($data as $item) {
            Stock::create($item);
        }
    }
}
