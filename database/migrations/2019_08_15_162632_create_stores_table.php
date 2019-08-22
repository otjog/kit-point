<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->string('alias', 45);
            $table->string('name', 45);
            $table->timestamps();
        });

        Schema::create('shop_store_has_product', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->integer('store_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->timestamps();
        });

        DB::table('shop_stores')->insert([
            'active' => 1,
            'alias' => 'belgorod',
            'name' => 'Склад компании',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_stores');
        Schema::dropIfExists('shop_store_has_product');
    }
}
