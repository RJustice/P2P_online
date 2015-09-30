<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_orders',function(Blueprint $table){
            $table->increments('id');
            $table->string('order_sn');
            $table->tinyInteger('type');
            $table->string('user_id',16);
            $table->timestamps();
            $table->tinyInteger('pay_status');
            $table->decimal('total_price',20,2);
            $table->decimal('pay_amount',20,2);
            $table->tinyInteger('order_status');
            $table->tinyInteger('is_deleted');
            $table->text('admin_meno');
            $table->text('memo');
            $table->string('mobile');
            $table->decimal('ecv_money',20,2);
            $table->decimal('account_money',20,2);
            $table->integer('payment_id');
            $table->decimal('payment_fee');
            $table->string('bank_id');
            $table->string('referer');
            $table->string('user_name');
            $table->date('create_date');
            $table->date('finish_date');
            $table->tinyInteger('company_id');
            $table->string('who_sale',25);
            $table->string('who_confirm',25);
            $table->tinyInteger('status')->default(0);

            // Deals 理财项目            
            $table->integer('deal_id');
            $table->string('deal_title');
            $table->string('deal_sub_title');
            $table->decimal('deal_daliy_returns',20,2);
            $table->decimal('deal_rate',20,2);
            $table->decimal('deal_waiting_returns',20,2);
            $table->tinyInteger('deal_type')->default(-1);

            // 索引
            $table->unique('order_sn');
            $table->index('deal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deal_orders');
    }
}
