<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    // protected $table="banks";
    protected $fillable = ['name','is_rec','day','sort','icon'];
    public $timestamps = false;

    public static function getBankOption($format = false){
        $banks = self::orderByRaw('is_rec desc,sort desc')->get();
        if( $banks ){
            if( $format ){
                foreach( $banks as $bank ){
                    $tmp[] = [
                        'label' => $bank->name,
                        'value' => $bank->id
                    ];
                }
            }else{
                foreach( $banks as $bank ){
                    $tmp[$bank->id] = $bank->name;
                }
            }
            return $tmp;
        }else{
            return [];
        }
    }
}
