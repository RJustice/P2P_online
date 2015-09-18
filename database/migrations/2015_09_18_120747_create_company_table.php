<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys',function(Blueprint $table){
            $table->increment('id');
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('county_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companys');
    }
}
