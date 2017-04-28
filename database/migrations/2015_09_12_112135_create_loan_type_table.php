<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_types',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('desc');
            $table->integer('pid');
            $table->tinyInteger('is_effect');
            $table->tinyInteger('is_deleted');
            $table->integer('sort');
            $table->string('icon');

            // 索引
            $table->index('pid');
            $table->index('sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loan_types');
    }
}
