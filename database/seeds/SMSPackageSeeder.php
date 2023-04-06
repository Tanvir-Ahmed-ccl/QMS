<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SMSPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = [
            "SILVER" => ["price" => 25, "sms_limit" => 1000], 
            "GOLD"  => ["price" => 40, "sms_limit" => 2500], 
            "PLATINUM" => ["price" => 60, "sms_limit" => 10000],
        ];

        foreach($p as $key => $val)
        {
            DB::table('s_m_s_packages')->insert([
                "title" =>  $key,
                "price" =>  $val['price'],
                "sms_limit" =>  $val['sms_limit'],
                "created_at"    =>  now()
            ]);
        }        
    }
}
