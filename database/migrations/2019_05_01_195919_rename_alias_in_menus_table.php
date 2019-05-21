<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAliasInMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('name', 'header');
            $table->renameColumn('alias', 'name');
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->string('name', 45)->unique()->change();
            $table->string('header', 100)->default('')->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('name', 'alias');
            $table->renameColumn('header', 'name');
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->string('name', 100)->change();
            $table->string('alias', 45)->change();
        });
    }
}
