<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@gmail.com','password' => bcrypt('hmis.admin'), 'designation' => 'Admin']
        ];
        if (User::whereIn('id', array_pluck($users, 'id'))->count() == 0) {
            User::insert($users);
        }
    }
}
