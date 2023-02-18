<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'product_name'    => '商品1',
                'category_id'     => 1,
                'manufacturer_id' => 1,
                'memo'            => '',
                'price'           => 1200,
                'is_selling'      => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'product_name'    => '商品2',
                'category_id'     => 2,
                'manufacturer_id' => 2,
                'memo'            => 'テスト',
                'price'           => 700,
                'is_selling'      => 0,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'product_name'    => '商品3',
                'category_id'     => 3,
                'manufacturer_id' => 3,
                'memo'            => 'テスト',
                'price'           => 2500,
                'is_selling'      => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('products')->insert($data);
    }
}
