<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDealOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_orders', function (Blueprint $table) {
            $table->tinyInteger('has_assign')->default(0);
            $table->decimal('assign_money',20,2);
            $table->string('pospic');
            $table->string('posno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deal_orders', function (Blueprint $table) {
            $table->dropColumn(['has_assign','assign_money','pospic','posno']);
        });
    }
}
