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
            'name' => 'Winston',
            'email' => 'winston@wirasukses.com',
            'role' => 'admin',
            'password' => bcrypt('gunnebo88'),
        ]);
    }
}
