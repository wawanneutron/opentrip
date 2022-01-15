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
            'name'      => 'Jhon Doe',
            'username'  => 'jhondoe',
            'email' => 'diki@test.test',
            'password'  => bcrypt('password'),
            'roles'     => 'ADMIN'
        ]);
    }
}
