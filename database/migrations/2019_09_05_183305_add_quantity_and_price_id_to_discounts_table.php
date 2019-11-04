<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityAndPriceIdToDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->integer('price_id')->unsigned()->after('to_date');
        });

        Schema::table('product_has_discount', function (Blueprint $table) {
            $table->integer('quantity')->unsigned()->default(1)->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('price_id');
        });

        Schema::table('product_has_discount', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
}