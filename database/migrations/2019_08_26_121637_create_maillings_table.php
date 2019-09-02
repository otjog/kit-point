<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $optionsComment = 'Для добавления товаров в рассылку использовать shop_offer, а в качестве значения - alias необходимого offer.';

        Schema::create('maillings', function (Blueprint $table) use ($optionsComment) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->string('alias', 45);
            $table->string('name', 45);
            $table->string('file_src', 255)->nullable();
            $table->string('time', 13);
            $table->integer('customer_group_id')->nullable();
            $table->jsonb('options')->nullable()->comment($optionsComment);
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
        Schema::dropIfExists('maillings');
    }
}
