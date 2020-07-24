<?php

use Illuminate\Database\Seeder;

class OfferInjection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $index = 1;
        // DB::table('companies')->insert([
        //     array('company_name' => 'PT. CHAROEN POKPHAND INDONESIA','company_address' => 'JL.  Sumbawa KIM I','company_tel' => '085358490794','company_email' => 'yusniar.yusniar@cp.co.id','company_industry' => '5'),
        //     array('company_name' => 'PT. GROWTH ASIA','company_address' => 'JL. Pulau Tidore Kav.B5  Kawasan Industri Medan 3 Medan 20525','company_tel' => '06188809798','company_email' => 'rina@growthsteel.com','company_industry' => NULL),
        //     array('company_name' => 'PT. JW MARRIOTT MEDAN','company_address' => 'JL. Putri Hijau No.10 Medan','company_tel' => '0614553333','company_email' => 'Anisah.Anisah@marriott.com','company_industry' => '7'),
        //     array('company_name' => 'PT. BERJAYA GROUP','company_address' => 'JL. Dr.Masyur','company_tel' => '085270656870','company_email' => 'citra@berjayagroup.co.id','company_industry' => '6'),
        //     array('company_name' => 'PT. PT JASAMARGA','company_address' => 'JL.  ALUMUNIUM RAYA . TANJUNG MULYA MEDAN','company_tel' => '0616611701','company_email' => NULL,'company_industry' => NULL),
        //     array('company_name' => 'PT. SINAR MAS AGRO RESOURCES TECHNOLOGY TBK.','company_address' => 'JL. Sinar Mas Land Plaza Tbk. Tower 2 , 22nd Floor , JL. Thamrin 51, Kav.22  Jakarta Pusat 10350','company_tel' => '02150333888','company_email' => 'beni.prasetio@sinarmas-agri.com','company_industry' => '3'),
        //     array('company_name' => 'PT. JAWA MANIS RAFINASI','company_address' => 'JL. RAYA ANYER KM.11, CIWANDAN CILEGON','company_tel' => '0254605520','company_email' => 'kholidi.iphay@wilmar.co.id','company_industry' => '9')
        // ]);

        // DB::table('contact_people')->insert([
        //     array('name' => 'MEIDANIATY SIMANJUNTAK','phone' => '082360486502','email' => 'meidaniaty.simanjuntak@cp.co.id'),
        //     array('name' => 'RIDWAN SYAHPUTRA','phone' => '082168548065','email' => 'ridwan.syahputra@cp.co.id'),
        //     array('name' => 'RINA','phone' => '081376888051','email' => 'rina@growthsteel.com'),
        //     array('name' => 'JESSICA','phone' => '081260818241','email' => 'jessica@growthsteel.com'),
        //     array('name' => 'ANISAH','phone' => '085373333116','email' => 'Anisah.Anisah@marriott.com'),
        //     array('name' => 'CITRA YUDI ANGGUN PRATIWI','phone' => '085270656870','email' => 'citra@berjayagroup.co.id'),
        //     array('name' => 'KHOLIDI','phone' => '081808238795','email' => 'KHOLIDI.IPHAY@WILMAR.CO.ID'),
        //     array('name' => 'SITI SURYATI','phone' => '085945921363','email' => 'SITI.SURYATI@WILMAR.CO.ID'),
        //     array('name' => 'BENI DEKTUS PRASETIO','phone' => '081284303515','email' => 'BENI.PRASETIO@SINARMAS-AGRI.COM'),
        //     array('name' => 'HARRY DWI PUTRA','phone' => '08111909988','email' => 'HARRY.D.PUTRA@SINARMAS-AGRI.COM')
        // ]);

        // DB::table('company_contact_sales')->insert([
        //     array('company_id'=>'1','contact_person_id'=>'1','sales_id' => '3'),
        //     array('company_id'=>'1','contact_person_id'=>'2','sales_id' => '3'),
        //     array('company_id'=>'2','contact_person_id'=>'3','sales_id' => '2'),
        //     array('company_id'=>'2','contact_person_id'=>'4','sales_id' => '2'),
        //     array('company_id'=>'3','contact_person_id'=>'5','sales_id' => '2'),
        //     array('company_id'=>'4','contact_person_id'=>'6','sales_id' => '2'),
        //     array('company_id'=>'7','contact_person_id'=>'7','sales_id' => '1'),
        //     array('company_id'=>'7','contact_person_id'=>'8','sales_id' => '1'),
        //     array('company_id'=>'6','contact_person_id'=>'9','sales_id' => '1'),
        //     array('company_id'=>'6','contact_person_id'=>'10','sales_id' => '1'),
        //     array('company_id'=>'4','contact_person_id'=>NULL,'sales_id' => '4')
        // ]);


        DB::table('offers_counter')->insert([
            array('ppn' => '1' ,'offer_number'=>"NULL",'created_at' => '2020-07-22 04:39:06','updated_at' => '2020-07-22 04:39:06'),
            array('ppn' => '1' ,'offer_number'=>"NULL",'created_at' => '2020-07-22 04:47:52','updated_at' => '2020-07-22 04:47:52'),
            array('ppn' => '1' ,'offer_number'=>"NULL",'created_at' => '2020-07-22 09:16:49','updated_at' => '2020-07-22 09:16:49'),
            array('ppn' => '1' ,'offer_number'=>"NULL",'created_at' => '2020-07-24 07:11:15','updated_at' => '2020-07-24 07:11:15'),
            array('ppn' => '1' ,'offer_number'=>"NULL",'created_at' => '2020-07-24 09:25:06','updated_at' => '2020-07-24 09:25:06')
        ]);

        DB::table('offers')->insert([
            array('status' => '2','information' => 'Penawaran Hydrant module type FZM 17','sales_id' => '2','company_id' => '4','offer_date' => '2020-07-22 00:00:00','purchase_order' => NULL,'offer_number' => '1'),
            array('status' => '2','information' => 'Penawaran Refilling FM200','sales_id' => '2','company_id' => '5','offer_date' => '2020-07-22 00:00:00','purchase_order' => NULL,'offer_number' => '2'),
            array('status' => '2','information' => 'Penawaran Harga Extinguisher Gunnebo Foam','sales_id' => '2','company_id' => '6','offer_date' => '2020-07-22 00:00:00','purchase_order' => NULL,'offer_number' => '3'),
            array('status' => NULL,'information' => 'Berkunjung ke PT JASA MARGA . menjumpai ibu Riska yunita pegawai anak perusahan  PT JASA MARGA','sales_id' => '4','company_id' => '7','offer_date' => '2020-07-16 00:00:00','purchase_order' => NULL,'offer_number' => NULL),
            array('status' => '2','information' => 'Penawaran Project FAS di PT. Smart Tarjun Tbk.','sales_id' => '1','company_id' => '8','offer_date' => '2020-07-24 00:00:00','purchase_order' => NULL,'offer_number' => '4'),
            array('status' => '2','information' => 'Penawaran untuk tambahan Fire Alarm System PT. JMR sesuai dengan hasil survei M. Harianto','sales_id' => '1','company_id' => '9','offer_date' => '2020-07-24 00:00:00','purchase_order' => NULL,'offer_number' => '5')
        ]);

        DB::table('products')->insert([
            array('name' => 'FIRE ZONE MODULE FZM-1','qty' => '3','price' => '1150000','offer_id' => '1'),
            array('name' => 'REFILLING FM-200 AGENT','qty' => '45','price' => '1272720','offer_id' => '2'),
            array('name' => 'O-RING SEAL','qty' => '1','price' => '4233600','offer_id' => '2'),
            array('name' => 'BIAYA SERVIS & TERSTING COMMISSIONING','qty' => '1','price' => '25000000','offer_id' => '2'),
            array('name' => 'Fire Extinguisher Foam Gunnebo 6 Liter','qty' => '1','price' => '1876050','offer_id' => '3'),
            array('name' => 'Fire Extinguisher Foam Gunnebo 9 Liter','qty' => '1','price' => '2227500','offer_id' => '3'),
            array('name' => 'Fire Alarm System PT. Smart Tarjun','qty' => '1','price' => '299950000','offer_id' => '5'),
            array('name' => 'Fire Alarm System','qty' => '1','price' => '147110550','offer_id' => '6')
        ]);
    }
}
