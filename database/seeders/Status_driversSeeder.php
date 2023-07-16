<?php

namespace Database\Seeders;

use App\Models\Statusdriver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Status_driversSeeder extends Seeder
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
                'name' => 'พร้อมทำงาน',
            ],
            [
                'name' => 'ลา',
            ],
        ];

        foreach ($data as $object) {
            Statusdriver::create($object);
        }
    }
}
