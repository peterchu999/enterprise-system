<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use DB;
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
        DB::table('users')->insert([
            'name' => 'San San',
            'email' => 'sales@wirasukses.com',
            'role' => 'employee',
            'password' => bcrypt('Halotron'),
        ]);
        DB::table('users')->insert([
            'name' => 'm.said',
            'email' => 'm.said@wirasukses.com',
            'role' => 'employee',
            'password' => bcrypt('Said2411'),
        ]);
        DB::table('users')->insert([
            'name' => 'Andri Ananta',
            'email' => 'andri.ananta@wirasukses.com',
            'role' => 'employee',
            'password' => bcrypt('indonesia 1979'),
        ]);
    }
}
