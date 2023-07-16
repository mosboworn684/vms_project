<?php

namespace Database\Seeders;

use App\Models\CarStatus;
use Illuminate\Database\Seeder;

class CarStatusTableSeeder extends Seeder
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
                'name' => 'พร้อมใช้งาน',
            ],
            [
                'name' => 'ไม่พร้อมใช้งาน',
            ],

        ];

        foreach ($data as $object) {
            CarStatus::create($object);
        }
    }
}
