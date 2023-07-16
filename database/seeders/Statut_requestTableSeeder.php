<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Illuminate\Database\Seeder;

class Statut_requestTableSeeder extends Seeder
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
                'name' => 'รออนุมัติ',
            ],
            [
                'name' => 'รอจัดรถ',
            ],
            [
                'name' => 'รอคืนรถ',
            ],
            [
                'name' => 'คืนรถแล้ว',
            ],
        ];

        foreach ($data as $object) {
            RequestStatus::create($object);
        }
    }
}
