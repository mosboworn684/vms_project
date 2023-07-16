<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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
                'prefix_id' => 1,
                'employeenumber' => 'AD001',
                'firstname' => 'บวร',
                'lastname' => 'งานอนุรักษ์วงศ์',
                'tel' => '0843216570',
                'email' => 'mosboworn@gmail.com',
                'username' => 'mosboworn',
                'password' => '123456789',
                'permission_id' => '1',
                'department_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'employeenumber' => 'MK001',
                'firstname' => 'ชลสิทธิ์',
                'lastname' => 'สว่างพงษ์',
                'tel' => '0863621470',
                'email' => 'chon@gmail.com',
                'username' => 'chonlasit',
                'password' => '123456789',
                'permission_id' => '2',
                'department_id' => '3',
            ],
            [
                'prefix_id' => 1,
                'employeenumber' => 'MK004',
                'firstname' => 'จิรวัฒน์',
                'lastname' => 'สำรอง',
                'tel' => '0333333333',
                'email' => 'lukna@gmail.com',
                'username' => 'lukna',
                'password' => '123456789',
                'permission_id' => '3',
                'department_id' => '3',
            ],
        ];

        foreach ($data as $object) {
            User::create($object);
        }
    }
}
