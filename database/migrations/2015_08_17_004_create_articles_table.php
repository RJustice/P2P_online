<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('content');
            $table->string('alias');
            $table->string('introtext')->index();
            $table->integer('categoryid');
            $table->integer('sectionid');
            $table->string('type')->default('normal');
            $table->tinyInteger('published')->default(0);
            $table->string('create_by');
            $table->string('out_link')->nullable();
            $table->string('from')->nullable();
            $table->string('images');
            $table->tinyInteger('ordering')->default(0);
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
        Schema::drop('articles');
    }
}
