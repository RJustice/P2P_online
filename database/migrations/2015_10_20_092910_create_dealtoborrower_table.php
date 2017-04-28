<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealtoborrowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_order_to_borrower',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('borrower_id');
            // $table->string('name',20);
            // $table->string('idno',20);
            $table->decimal('money',20,2);
            // $table->string('use');
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
        Schema::drop('deal_order_to_borrower');
    }
}
