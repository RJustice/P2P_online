<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarryConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_carry_config',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->decimal('min_price',20,2);
            $table->decimal('max_price',20,2);
            $table->decimal('fee',20,2);
            $table->tinyInteger('fee_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_carry_config');
    }
}
