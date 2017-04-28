<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Borrower;
use App\DealOrder;
use DB;

class OrderToBorrower extends Model
{
    protected $table = 'deal_order_to_borrower';
    protected $fillable = ['order_id','borrower_id','money'];

    protected static function assignBorrowersAll(){
        $rs = Borrower::where('repay_start','<=',date('Y-m-d'))->where('repay_end','>',date('Y-m-d'))->where('is_deleted',0)->where('loan','>','has_assign_money');
        $borrowers = [];
        if( $rs ){
            foreach( $rs as $borrower ){
                $borrowers[$borrower->getKey()] = '';
            }
        }
    }

    protected static function assignBorrowersByOrder($dealOrder){
        $needAssignMoney = $dealOrder->total_price;
        $splitMoney = self::_splitMoney($needAssignMoney);
        // $tmp = $splitMoney;
        // asort($tmp);
        // $max = $tmp[count($tmp)-1];
        // $tmp = [];
        // foreach( $splitMoney as $assignMoney ){

        // }
        // $rs = Borrower::where('repay_end','>=',date('Y-m-d'))->where('is_deleted',0)->whereRaw('loan - has_assign_money >= ?',[$max])->get();
        // if( $rs ){

        // }
        foreach( $splitMoney as $assignMoney ){
            // $rs = DB::select("SELECT * FROM `borrowers` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `borrowers`)-(SELECT MIN(id) FROM `borrowers`))+(SELECT MIN(id) FROM `borrowers`)) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id LIMIT 1");
            $borrower = Borrower::join(DB::raw("(SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `borrowers`)-(SELECT MIN(id) FROM `borrowers`))+(SELECT MIN(id) FROM `borrowers`)) AS id) AS t2"),"borrowers.id","=","t2.id")->orderBy("borrowers.id")->take(1)->first();
            $data['order_id'] = $dealOrder->getKey();
            $data['borrower_id'] = $borrower->getKey();
            $data['money'] = $assignMoney;
            self::create($data);
            $borrower->has_assign_money = $borrower->has_assign_money + $assignMoney;
            $borrower->save();
        }
        $dealOrder->has_assign = 1;
        $dealOrder->assign_money = $dealOrder->total_price;
        $dealOrder->save();
    }

    protected static function _randNum($money){
        if( $money >= 1 && $money <= 50000 ){
            $rand = mt_rand(1,2);
        }elseif( $money > 50000 && $money <= 100000 ){
            $rand = mt_rand(2,3);
        }elseif( $money > 100000 && $money <= 200000 ){
            $rand = mt_rand(2,5);
        }elseif( $money > 200000 && $money <= 300000 ){
            $rand = mt_rand(3,5);
        }elseif( $money > 300000 && $money <= 500000 ){
            $rand = mt_rand(4,8);
        }elseif( $money > 500000 && $money <= 100000 ){
            $rand = mt_rand(5,12);
        }else{
            $rand = mt_rand(7,15);
        }
        return $rand;
    }

    protected static function _splitMoney($money){
        $rand = self::_randNum($money);
        if( $rand == 1 ){
            return [$money];
        }
        $tmp = $money;
        $m = floor( $money / 10000 );
        $n = $money % 10000;
        if( $m <= 1 ){
            return [10000, $money-10000];
        }
        // $x = 1;
        // if( $m < 3 ){
        //     $z = 1;
        // }elseif( $m < 10 ){
        //     $z = 1;
        // }elseif( $m < 30 ){
        //     $z = 3;
        // }elseif( $m < 50 ){
        //     $z = 4;
        // }else{
        //     $z = 6;
        // }
        for($i=0;$i<$rand;$i++){
            // $r = floor( $m / $z );
            $t = mt_rand(1,$m / 2);
            $m = $m - $t;
            $x[] = $t;
        }

        $return = [];
        foreach( $x as $v ){
            $return[] = 10000 * $v;
        }
        $return[count($return)-1] = $return[count($return)-1] + $m * 10000 + $n;
        return $return;
    }
}
