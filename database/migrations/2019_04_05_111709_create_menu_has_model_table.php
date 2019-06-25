<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuHasModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_has_model', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->string('menu_model_id', 45);
            $table->string('ids', 255)->default(0);
            $table->string('header', 45)->default('Заголовок меню');
            $table->enum('view', ['dropdown', 'line']);
            $table->smallInteger('sort')->unsigned()->default(999);
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
        Schema::dropIfExists('menu_has_model');
    }
}
