<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCarryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_carry',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->decimal('money',20,2);
            $table->decimal('fee',20,2);
            $table->integer('bank_id');
            $table->string('bank_card');
            $table->timestamps();
            $table->tinyInteger('status');
            $table->text('msg');
            $table->text('desc');
            $table->string('real_name');
            $table->integer('region_lv1');
            $table->integer('region_lv2');
            $table->integer('region_lv3');
            $table->integer('region_lv4');
            $table->string('bankzone');
            $table->date('create_date');

            // 索引
            $table->index('create_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_carry');
    }
}
