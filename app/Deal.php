<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    // protected $table = "deals";
    protected $guarded = ['id'];

    const LOANTYPE_DENGEBENXI = 0;
    const LOANTYPE_FUXIFANBEN = 1;
    const LOANTYPE_DAOQI = 2;

    protected function loanTypeOption(){
        return [
            self::LOANTYPE_DENGEBENXI => '等额本息',
            self::LOANTYPE_FUXIFANBEN => '月付息到期返本',
            self::LOANTYPE_DAOQI => '到期付息返本',
        ];
    }

    public static function getLoanTypeTitle($loantype){
        $loantypes = $this->loanTypeOption();
        if( array_key_exists($loantype, $loantypes)){
            return $loantypes[$loantype];
        }else{
            return "未知类型";
        }
    }

    public static function getLoanTypeOption($format = false){
        $loantypes = $this->loanTypeOption();
        if( $format ){
            foreach( $loantypes as $k=>$loantype){
                $tmp[] = [
                    'label' => self::getLoanTypeTitle($k),
                    'value' => $k
                ];
            }
            return $tmp;
        }else{
            return $loantypes;
        }
    }
}
