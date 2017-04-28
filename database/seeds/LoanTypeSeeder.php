<?php

use Illuminate\Database\Seeder;
use App\LoanType;


class LoanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_types')->delete();

        $initData = [
            ['1', '短期周转', '', '0', '0', '1', '10', '/images/dealtype/dqzz.png',],
            ['2', '购房借款', '', '0', '0', '1', '9', '/images/dealtype/gf.png',],
            ['3', '装修借款', '', '0', '0', '1', '8', '/images/dealtype/zx.png',],
            ['4', '个人消费', '', '0', '0', '1', '7', '/images/dealtype/grxf.png',],
            ['5', '婚礼筹备', '', '0', '0', '1', '6', '/images/dealtype/hlcb.png',],
            ['6', '教育培训', '', '0', '0', '1', '5', '/images/dealtype/jypx.png',],
            ['7', '汽车消费', '', '0', '0', '1', '4', '/images/dealtype/qcxf.png',],
            ['8', '投资创业', '', '0', '0', '1', '3', '/images/dealtype/tzcy.png',],
            ['9', '医疗支出', '', '0', '0', '1', '2', '/images/dealtype/ylzc.png',],
            ['10', '其他借款', '', '0', '0', '1', '1', '/images/dealtype/other.png',],
        ];

        foreach($initData as $loan){
            LoanType::create([
                    'name' => $loan[1],
                    'desc' => '',
                    'is_effect' => 1,
                    'is_deleted' => 0,
                    'pid' => 0,
                    'sort' => $loan[6],
                    'icon' => $loan[7],
                ]);
        }
    }
}
