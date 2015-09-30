<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_banks',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('bank_id')->index();
            $table->string('bank_name');
            $table->string('bankcard');
            $table->string('real_name');
            $table->string('bankzone');
            $table->integer('region_lv1');
            $table->integer('region_lv2');
            $table->integer('region_lv3');
            $table->integer('region_lv4');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_banks');
    }
}
