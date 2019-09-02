<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_customer_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->string('alias', 45);
            $table->string('name', 45);
            $table->integer('price_id');
            $table->tinyInteger('default')->unsigned()->default(0);
            $table->timestamps();
        });

        /**
         * Получаем список price_id которые уже были назначены покупателям
         */
        $price_ids = DB::table('shop_customers')->select('price_id')->distinct('price_id')->get()->toArray();

        /**
         * Из таблицы prices получаем price_id, alias и name будущих customer_groups
         */
        $prices = [];
        foreach ( $price_ids as $price_id) {
            $prices[] = DB::table('prices')
                ->select('id as price_id', 'name as alias', 'comment as name')
                ->where('id', $price_id->price_id)
                ->first();
        }
        $prices = json_decode(json_encode($prices), true);

        /**
         * Вставляем новые customer_groups
         */
        $replaceArray = [];
        foreach ($prices as $price) {
            $groupId = DB::table('shop_customer_groups')->insertGetId($price);

            $replaceArray[] = [
                'price_id' => $price['price_id'],
                'customer_group_id' => $groupId
            ];
        }

        foreach ($replaceArray as $replace) {
            DB::table('shop_customers')
                ->where('price_id', $replace['price_id'])
                ->update(['price_id' => $replace['customer_group_id']]);
        }

        /**
         * Переименовываем у покупателей колонку price_id в customer_group_id
         */
        Schema::table('shop_customers', function($table)
        {
            $table->renameColumn('price_id', 'customer_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $groups = DB::table('shop_customer_groups')
            ->select('id as customer_group_id', 'price_id')
            ->get();

        $groups = json_decode(json_encode($groups), true);

        foreach ($groups as $group) {
            DB::table('shop_customers')
                ->where('customer_group_id', $group['customer_group_id'])
                ->update(['customer_group_id' => $group['price_id']]);
        }

        Schema::table('shop_customers', function($table)
        {
            $table->renameColumn('customer_group_id', 'price_id');
        });

        Schema::dropIfExists('shop_customer_groups');
    }
}
