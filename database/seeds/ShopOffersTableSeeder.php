<?php

use Illuminate\Database\Seeder;

class ShopOffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('shop_offers')->insert([
            [
                'active'        => 1,
                'name'          => 'deal-week',
                'header'        => 'Товары недели!',
                'related'       => '1',
            ],
            [
                'active'        => 1,
                'name'          => 'featured',
                'header'        => 'Рекомендуем',
                'related'       => '1',
            ],
            [
                'active'        => 1,
                'name'          => 'sale',
                'header'        => 'Распродажа',
                'related'       => '0',
            ],
            [
                'active'        => 1,
                'name'          => 'rated',
                'header'        => 'Популярные',
                'related'       => '0',
            ],
            [
                'active'        => 1,
                'name'          => 'newest',
                'header'        => 'Новые',
                'related'       => '0',
            ],
        ]);
    }
}
