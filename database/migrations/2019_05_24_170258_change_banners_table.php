<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('img');
            $table->dropColumn('sort');
            $table->renameColumn('title', 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('source', 45)->after('active');
            $table->string('img', 255)->nullable()->after('source');
            $table->renameColumn('name', 'title');
            $table->smallInteger('sort')->unsigned()->default(999)->after('name');
        });
    }
}
