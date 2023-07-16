<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(BrandsTableSeeder::class);
        $this->call(CarStatusTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(PrefixTableSeeder::class);
        $this->call(TypeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(Status_driversSeeder::class);
        $this->call(Statut_requestTableSeeder::class);
        $this->call(Status_setTableSeeder::class);
        $this->call(ModelSeeder::class);
        $this->call(DriverSeeder::class);
    }
}
