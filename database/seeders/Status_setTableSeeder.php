<?php

namespace Database\Seeders;

use App\Models\StatusSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Status_setTableSeeder extends Seeder
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
                'name' => 'ยังไม่ได้จัดรถยนต์',
            ],
            [
                'name' => 'จัดรถยนต์แล้ว',
            ],
            [
                'name' => 'ยังไมได้จัดคนขับ',
            ],
            [
                'name' => 'จัดคนขับแล้ว',
            ],
        ];
        foreach ($data as $object) {
            StatusSet::create($object);
        }
    }
}
