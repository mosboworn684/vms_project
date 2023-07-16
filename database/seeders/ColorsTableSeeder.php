<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
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
                'name' => 'สีแดง',
            ],
            [
                'name' => 'สีขาว',
            ],
            [
                'name' => 'สีดำ',
            ],
        ];

        foreach ($data as $object) {
            Color::create($object);
        }
    }
}
