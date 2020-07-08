<?php

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
        DB::table('users')->insert([
            'name' => 'User1',
            'email' => 'asd@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('asdasdasd'),
        ]);
    }
}
