<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'company_name' => "SHINTA VR",
            'company_address' => "Jalan bambu no 38",
            'company_tel' => "0909123444",
            'company_email' => null,
            'company_industry' => 1,
            'sales_id' => null
        ]);
        DB::table('companies')->insert([
            'company_name' => "Kacha VR",
            'company_address' => "Jalan bambu no 38",
            'company_tel' => "0909123444",
            'company_email' => null,
            'company_industry' => 2,
            'sales_id' => null
        ]);
    }
}
