<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {            
            // $table->dropUnique('users_username_unique');
            // $table->dropUnique('users_phone_unique');

            $table->string('hash_id',8)->after('id');
            $table->string('login_ip');
            $table->tinyInteger('is_deleted');
            $table->string('idno',20);
            $table->tinyInteger('idcardpassed');
            $table->Integer('idcardpassed_time');
            $table->string('real_name',50);
            $table->tinyInteger('phonepassed');
            $table->decimal('money',20,2)->default(0);
            $table->decimal('lock_money',20,2)->default(0);
            $table->decimal('can_money',20,2)->default(0);
            $table->decimal('waiting_returns',20,2)->default(0);
            $table->integer('sales_manager'); // 销售经理
            $table->integer('pid');  // 推荐人ID
            $table->string('verify');
            $table->string('code');
            $table->string('referer_memo'); // 推荐备忘
            $table->integer('referral_count'); // 推荐人数
            $table->integer('score');
            $table->integer('login_time');
            $table->string('password_verify');
            $table->string('referer'); // 会员来源
            $table->integer('n_province_id');  // 户籍
            $table->integer('n_city_id');   // 户籍
            $table->integer('n_county_id');   // 户籍
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('county_id');
            $table->tinyInteger('sex');
            $table->tinyInteger('step');
            $table->integer('byear');
            $table->integer('bmonth');
            $table->integer('bday');
            $table->string('address');
            $table->string('paypassword',60);
            $table->integer('modified_uid');
            $table->integer('company_id')->default(1);

            // $table->dropUnique('username');
            // $table->dropUnique('phone');

            $table->unique('username');
            $table->unique('phone');
            $table->index('idno');
            $table->index('hash_id');
            // $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_idno_index');
            $table->dropIndex('users_hash_id_index');
            $table->dropUnique('users_username_unique');
            $table->dropUnique('users_phone_unique');
            $table->dropColumn(['hash_id','login_ip','is_deleted','idno','idcardpassed','idcardpassed_time','real_name','phonepassed','money','lock_money','can_money','waiting_returns','sales_manager','pid','verify','code','referer_memo','referral_count','score','login_time','password_verify','referer','n_province_id','n_city_id','province_id','city_id','sex','step','byear','bmonth','bday','address','paypassword','company_id','modified_uid','n_county_id','county_id']);
        });
    }
}
