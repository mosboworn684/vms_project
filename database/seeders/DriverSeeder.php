<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
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
                'prefix_id' => 1,
                'drivernumber'=> '07127405',
                'firstname' => 'เอ',
                'lastname' => 'เออีบีซี',
                'tel' => '0874125247',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '07177494',
                'firstname' => 'กล้อง',
                'lastname' => 'พันศรี',
                'tel' => '0874125250',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '47127494',
                'firstname' => 'ธันวา',
                'lastname' => 'นิรุธ',
                'tel' => '0874125249',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '07627494',
                'firstname' => 'ธนพล',
                'lastname' => 'เยี่ยมจริง',
                'tel' => '0874125248',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '61478217',
                'firstname' => 'สมรวย',
                'lastname' => 'เก่งๆ',
                'tel' => '0222222222',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '61478219',
                'firstname' => 'ฉัตรชัย',
                'lastname' => 'มงคล',
                'tel' => '0971478217',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '07147821',
                'firstname' => 'สมบัติ',
                'lastname' => 'มากมี',
                'tel' => '0862422684',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber'=> '07127494',
                'firstname' => 'มงคลกิต',
                'lastname' => 'เฉลิมชัย',
                'tel' => '0892174782',
                'status_id' => '1',
            ],
            [
                'prefix_id' => 1,
                'drivernumber' => '60782147',
                'firstname' => 'สมศักดิ์',
                'lastname' => 'เทพ',
                'tel' => '0914702147',
                'status_id' => '1',
            ],
        ];

        foreach ($data as $object) {
            Driver::create($object);
        }
    }
}
