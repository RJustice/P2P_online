<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Borrower;
use App\DealOrder;

class OrderToBorrower extends Model
{
    protected $table = 'deal_order_to_borrower';

    protected static function assignBorrowersAll(){
        $rs = Borrower::where('repay_start','<=',date('Y-m-d'))->where('repay_end','>',date('Y-m-d'))->where('is_deleted',0)->where('loan','>=','has_assign_money');
        $borrowers = [];
        foreach( $rs as $borrower ){
            $borrowers[$borrower->getKey()] = '';
        }
    }

    protected static function assignBorrowersByOrder($dealOrder){
        
    }
}
