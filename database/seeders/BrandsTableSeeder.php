<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'name' => 'HONDA',
            ],
            [
                'name' => 'ISUZU',
            ],
            [
                'name' => 'MAZDA',
            ],
            [
                'name' => 'NISSAN',
            ],
            [
                'name' => 'TOYOTA',
            ],
            [
                'name' => 'MG',
            ]
        ];

        foreach ($data as $object) {
            Brand::create($object);
        }
    }
}
