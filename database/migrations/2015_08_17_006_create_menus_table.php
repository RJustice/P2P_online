<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu_type');
            $table->string('name');
            $table->string('link');
            $table->tinyInteger('published')->default(1);
            $table->tinyInteger('new_tab')->default(0);
            $table->integer('parent');
            $table->tinyInteger('ordering')->default(0);
            $table->text('params');
            $table->string('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
