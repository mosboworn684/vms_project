<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
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
                'name' => 'ส่วนกลาง',
                'code' => 'AD',
            ],
            [
                'name' => 'บุคคล',
                'code' => 'HR',
            ],
            [
                'name' => 'การตลาด',
                'code' => 'MK',
            ],
            [
                'name' => 'ไอที',
                'code' => 'IT',
            ],
            [
                'name' => 'บัญชี',
                'code' => 'AC',
            ],
        ];

        foreach ($data as $object) {
            Department::create($object);
        }
    }
}
