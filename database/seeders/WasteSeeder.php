<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wastes')->insert([
        ['name' => 'botol', 'point_value' => 10],
        ['name' => 'besi', 'point_value' => 20],
        ['name' => 'kaleng', 'point_value' => 15],
    ]);
    }
}
