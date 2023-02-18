<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $set_num = 5;
        $default_categories = [];

        while($i <= $set_num) {
            $default_categories[] = [
                'category_name' => "カテゴリー{$i}",
                'is_display'    => mt_rand(0,1),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $i++;
        }

        DB::table('categories')->insert($default_categories);
    }
}
