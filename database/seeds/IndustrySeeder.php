<?php

use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industries')->insert([
            ['name' => 'GUDANG'],
            ['name' => 'PERBANKAN'],
            ['name' => 'PABRIK KELAPA SAWIT'],
            ['name' => 'PERKEBUNAN SAWIT'],
            ['name' => 'PERUSAHAAN PAKAN TERNAK'],
            ['name' => 'PERUSAHAAN KONTRAKTOR'],
            ['name' => 'PERUSAHAAN SUPPLIER'],
            ['name' => 'PERUSAHAAN ELEKTRONIK']
        ]);
    }
}
