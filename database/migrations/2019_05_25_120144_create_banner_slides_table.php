<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->integer('banner_id');
            $table->string('url', 255)->nullable();
            $table->string('template', 45)->default('default');
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
        Schema::dropIfExists('banner_slides');
    }
}
