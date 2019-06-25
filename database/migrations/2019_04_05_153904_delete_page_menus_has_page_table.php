<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePageMenusHasPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('page_menu_has_page');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('page_menu_has_page', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->integer('page_id');
            $table->timestamps();
        });
    }
}
