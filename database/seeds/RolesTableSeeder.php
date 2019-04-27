<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Admin', 'code' => 'admin'],
            ['id' => 2, 'name' => 'Doctor', 'code' => 'doctor'],
            ['id' => 3, 'name' => 'Accountant', 'code' => 'accountant'],
            ['id' => 4, 'name' => 'Laboratorist', 'code' => 'laboratorist'],
            ['id' => 5, 'name' => 'Nurse', 'code' => 'nurse'],
            ['id' => 6, 'name' => 'Pharmacist', 'code' => 'pharmacist'],
            ['id' => 7, 'name' => 'Receptionist', 'code' => 'receptionist']
        ];
        if (Role::whereIn('id', array_pluck($roles, 'id'))->count() == 0) {
            Role::insert($roles);
        }
    }
}
