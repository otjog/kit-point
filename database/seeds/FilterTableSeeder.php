<?php

use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('filters')->insert([
            [
                'active'    => 1,
                'alias'     => 'price',
                'name'      => 'Цена',
                'sort'      => '10',
                'type'      => 'slider-range'
            ],
            [
                'active'    => 1,
                'alias'     => 'manufacturer',
                'name'      => 'Производитель',
                'sort'      => '20',
                'type'      => 'checkbox'
            ],
            [
                'active'    => 1,
                'alias'     => 'category',
                'name'      => 'Категория',
                'sort'      => '30',
                'type'      => 'checkbox'
            ],
        ]);

    }
}
