<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('customers', 'shop_customers');

        Schema::table('shop_customers', function (Blueprint $table) {
            $table->string('password', 255)->after('phone');
            $table->rememberToken()->after('password');
            $table->string('email')->inique()->change();
            $table->integer('price_id')->default(1)->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('shop_customers', 'customers');

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['password', 'remember_token', 'price_id']);
            $table->string('email', 30)->change();
        });
    }
}
