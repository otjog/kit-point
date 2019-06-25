<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            Schema::dropIfExists('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            Schema::create('brands', function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('active')->unsigned()->default(0);
                $table->string('name', 45);
                $table->timestamps();
            });
        });
    }
}
