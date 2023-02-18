<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $set_num = 10;
        $default_manufacturers = [];
        
        while($i <= $set_num) {
            $default_manufacturers[] = [
                'manufacturer_name' => "メーカー{$i}",
                'other'             => bin2hex(random_bytes(16)),
                'is_display'        => mt_rand(0,1),
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            $i++;
        }

        DB::table('manufacturers')->insert($default_manufacturers);
    }
}
