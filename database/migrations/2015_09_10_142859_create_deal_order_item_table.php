<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_order_items',function(Blueprint $table){
            $table->increments('id');
            $table->integer('deal_id');
            $table->integer('number');
            $table->decimal('unit_price',20,2);
            $table->decimal('total_price',20,2);
            $table->string('name');
            $table->string('sub_title');
            $table->string('verify_code');
            $table->integer('deal_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deal_order_items');
    }
}
