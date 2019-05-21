<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePageMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('page_menus');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('page_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->string('alias', 45);
            $table->string('name', 100);
            $table->smallInteger('sort')->unsigned()->default(999);
            $table->timestamps();
        });
    }
}
