<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals',function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('sub_title');
            $table->text('description');
            $table->tinyInteger('is_effect');
            $table->tinyInteger('is_deleted');
            $table->integer('sort');
            $table->string('icon');
            $table->tinyInteger('is_hot');
            $table->tinyInteger('is_new');
            $table->tinyInteger('is_best');
            $table->decimal('borrow_amount',20,2);  //投资总额
            $table->decimal('min_loan_money',20,2);
            $table->decimal('max_loan_money',20,2);
            $table->decimal('rate',10,2);
            $table->decimal('daliy_returns',20,2);
            $table->timestamps();
            $table->tinyInteger('is_rec');
            $table->integer('buy_count');  // 多少人投资
            $table->decimal('load_money',20,2);  // 已经获得多少
            // $table->integer('cate_id'); // 分类
            $table->tinyInteger('published');
            $table->tinyInteger('loantype'); // 还款方式
            $table->string('titlecolor');
            $table->string('deal_sn'); // 投资编号, 唯一, 自定义


            // 索引
            // $table->index('cate_id');
            $table->index('sort');
            $table->index('created_at');
            $table->index('updated_at');
            // $table->index('user_id');
            // $table->index(['user_id','published']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deals');
    }
}
