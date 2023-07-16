<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
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
                'name' => 'ผู้ดูแลระบบ',
            ],
            [
                'name' => 'หัวหน้าแผนก',
            ],
            [
                'name' => 'พนักงาน',
            ],
        ];

        foreach ($data as $object) {
            Permission::create($object);
        }
    }
}
