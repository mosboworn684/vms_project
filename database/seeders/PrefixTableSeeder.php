<?php

namespace Database\Seeders;

use App\Models\Prefix;
use Illuminate\Database\Seeder;

class PrefixTableSeeder extends Seeder
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
                'name' => 'นาย',
            ],
            [
                'name' => 'นางสาว',
            ],
            [
                'name' => 'นาง',
            ],
        ];

        foreach ($data as $object) {
            Prefix::create($object);
        }
    }
}
