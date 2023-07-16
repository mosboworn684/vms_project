<?php

namespace Database\Seeders;

use App\Models\Typecar;
use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
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
                'name' => 'เก๋ง',
            ],
            [
                'name' => 'SUV',
            ],
            [
                'name' => 'กระบะ',
            ],
            [
                'name' => 'รถตู้',
            ],
        ];

        foreach ($data as $object) {
            Typecar::create($object);
        }
    }
}
