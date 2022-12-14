<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('isps')->truncate();

        DB::table('isps')->insert([
            'isp_name' => 'gmail',
        ]);
        
        DB::table('isps')->insert([
            'isp_name' => 'hotmail',
        ]);
        
        DB::table('isps')->insert([
            'isp_name' => 'mailforspam',
        ]);
        
        DB::table('isps')->insert([
            'isp_name' => 'yahoo',
        ]);
    }
}
