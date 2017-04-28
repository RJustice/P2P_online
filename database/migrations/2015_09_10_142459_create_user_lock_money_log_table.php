<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLockMoneyLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_lock_money_logs',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->decimal('lock_money',20,2);
            $table->decimal('account_money',20,2);
            $table->decimal('can_money',20,2);
            $table->text('memo');
            $table->tinyInteger('type');
            $table->timestamp('created_at');
            $table->date('create_time_ymd');
            $table->integer('create_time_ym');
            $table->integer('create_time_y');
            $table->string('proof');

            // 索引
            $table->index(['user_id','type','created_at']);
            $table->index(['user_id','type','create_time_ymd']);
            $table->index(['user_id','type']);
            $table->index(['create_time_ymd']);
            $table->index(['type','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_lock_money_logs');
    }
}
