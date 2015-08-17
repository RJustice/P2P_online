<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->index();
            $table->string('alias',50)->index();
            $table->integer('parent_id')->index();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('count')->default(0);
            $table->tinyInteger('ordering')->default(0);
            $table->tinyInteger('published')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category');
    }
}
