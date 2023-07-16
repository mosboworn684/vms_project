<?php

namespace Database\Seeders;

use App\Models\CarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $data = [
        [
            'name' => 'ZS',
            'brand_id' => 6,
        ],
        [
            'name' => 'Hilux Revo Rocco',
            'brand_id' => 5,
        ],
        [
            'name' => 'Hilux Revo',
            'brand_id' => 5,
        ],
        [
            'name' => 'Alphard Hybrid',
            'brand_id' => 5,
        ],
        [
            'name' => 'Mobilio',
            'brand_id' => 1,
        ],
        [
            'name' => 'CX-8',
            'brand_id' => 3,
        ]
    ];

    foreach ($data as $object) {
        CarModel::create($object);
        }
    }
}
