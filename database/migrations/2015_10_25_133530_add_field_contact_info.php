<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldContactInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_info', function (Blueprint $table) {
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('county_id');
            $table->string('fb_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_info', function (Blueprint $table) {
            $table->dropColumn(['province_id','city_id','county_id','fb_time']);
        });
    }
}
