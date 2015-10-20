<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20);
            $table->string('idno',20);
            $table->decimal('loan',20,2)->default(0);
            $table->string('use');
            $table->date('repay_start');
            $table->date('repay_end');
            $table->integer('periods');
            $table->tinyInteger('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('borrowers', function (Blueprint $table) {
        //     //
        // });
        Schema::drop('borrowers');
    }
}
