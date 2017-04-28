<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderToRedeem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_order_to_redeem',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id');
            $table->string('order_sn');
            $table->decimal('order_money');
            $table->decimal('order_return');
            $table->integer('user_id');
            $table->tinyInteger('status')->default(0);
            $table->integer('who_confirm');
            $table->text('meno');
            $table->timestamps();

            $table->unique(['order_id','user_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deal_order_to_redeem');
    }
}
