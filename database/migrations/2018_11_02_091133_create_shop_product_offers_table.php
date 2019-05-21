<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopProductOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->string('name', 25);
            $table->string('header', 14);
            $table->tinyInteger('related')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_offers');
    }
}
