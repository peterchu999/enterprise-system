<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmpy = Company::create([
            'company_name'=>'hidenburg',
            'company_address' => 'Jalan Chiga Selatan',
            'company_industry' => 1,
        ])->CompanyContactSales()->create([
            'sales_id' => 1
        ]);
        
        $arg = $cmpy->ContactPerson()->create([
            'name' => 'loremsan',
            'phone' => '0888129324'
        ]);
        $cmpy->contact_person_id = $arg->id;
        $cmpy->save();
    }
}
