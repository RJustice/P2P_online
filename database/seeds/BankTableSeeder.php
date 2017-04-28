<?php

use Illuminate\Database\Seeder;
use App\Bank;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->delete();
        $initData = [
            ['中国工商银行', '1', '3', '0', '/images/bank/1.jpg'],
            ['中国农业银行', '1', '3', '0', '/images/bank/2.jpg'],
            ['中国建设银行', '1', '3', '0', '/images/bank/3.jpg'],
            ['招商银行', '1', '3', '0', '/images/bank/4.jpg'],
            ['中国光大银行', '1', '3', '0', '/images/bank/5.jpg'],
            ['中国邮政储蓄银行', '1', '3', '0', '/images/bank/6.jpg'],
            ['兴业银行', '1', '3', '0', '/images/bank/7.jpg'],
            ['中国银行', '0', '3', '0', '/images/bank/8.jpg'],
            ['交通银行', '0', '3', '3', '/images/bank/9.jpg'],
            [ '中信银行', '0', '3', '0', '/images/bank/10.jpg'],
            [ '华夏银行', '0', '3', '0', '/images/bank/11.jpg'],
            [ '上海浦东发展银行', '0', '3', '1', '/images/bank/12.jpg'],
            // [ '城市信用社', '0', '3', '0', '/images/bank/13.jpg'],
            // [ '恒丰银行', '0', '3', '0', '/images/bank/14.jpg'],
            [ '广东发展银行', '0', '3', '0', '/images/bank/15.jpg'],
            [ '深圳发展银行', '0', '3', '2', '/images/bank/16.jpg'],
            [ '中国民生银行', '0', '3', '0', '/images/bank/17.jpg'],
            // [ '中国农业发展银行', '0', '3', '0', '/images/bank/18.jpg'],
            // [ '农村商业银行', '0', '3', '0', '/images/bank/19.jpg'],
            // [ '农村信用社', '0', '3', '0', '/images/bank/20.jpg'],
            // [ '城市商业银行', '0', '3', '0', '/images/bank/21.jpg'],
            // [ '农村合作银行', '0', '3', '0', '/images/bank/22.jpg'],
            [ '浙商银行', '0', '3', '0', '/images/bank/23.jpg'],
            // [ '上海农商银行', '0', '3', '0', '/images/bank/24.jpg'],
            // [ '中国进出口银行', '0', '3', '0', '/images/bank/25.jpg'],
            // [ '渤海银行', '0', '3', '0', '/images/bank/26.jpg'],
            // [ '国家开发银行', '0', '3', '0', '/images/bank/27.jpg'],
            // [ '村镇银行', '0', '3', '0', '/images/bank/28.jpg'],
            // [ '徽商银行股份有限公司', '0', '3', '0', '/images/bank/29.jpg'],
            // [ '南洋商业银行', '0', '3', '0', '/images/bank/30.jpg'],
            // [ '韩亚银行', '0', '3', '0', '/images/bank/31.jpg'],
            // [ '花旗银行', '0', '3', '0', '/images/bank/32.jpg'],
            // [ '渣打银行', '0', '3', '0', '/images/bank/33.jpg'],
            // [ '华一银行', '0', '3', '0', '/images/bank/34.jpg'],
            // [ '东亚银行', '0', '3', '0', '/images/bank/35.jpg'],
            // [ '苏格兰皇家银行', '1', '1', '26', '/images/bank/36.jpg'],
        ];

        foreach($initData as $bank){
            Bank::create([
                    'name' => $bank[0],
                    'is_rec' => $bank[1],
                    'day' => $bank[2],
                    'sort' => $bank[3],
                    'icon' => $bank[4]
                ]);
        }
    }
}
