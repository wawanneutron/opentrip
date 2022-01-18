<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'userid'    => 'ID-BNH627',
            'name'      => 'Jhon Doe',
            'username'  => 'jhondoe',
            'email' => 'jhondoe@test.test',
            'password'  => bcrypt('password'),
            'is_admin'     => true
        ]);
    }
}
