<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('offers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    	for($i = 1; $i <= 50; $i++){
    		DB::table('offers')->insert([
    			'status' => $faker->numberBetween(1,4),
    			'information' => $faker->realText($maxNbChars = 200, $indexSize = 2),
    			'offer_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'purchase_order' => $faker->uuid,
                'sales_id' => 1,
                'company_id' => 1,
                'offer_number' => null
    		]);
    	}
    }
}
