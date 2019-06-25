<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBasketValueToProductHasParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_has_parameter', function (Blueprint $table) {
            $table->float('basket_value', 10, 2)->default(0)->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_has_parameter', function (Blueprint $table) {
            $table->dropColumn('basket_value');
        });
    }
}
