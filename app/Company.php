<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Region;

class Company extends Model
{
    protected $table = 'companys';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    const STATUS_VAILD = 1;
    const STATUS_INVAILD = 0;

    public static function getCompanyOption($format = false){
        $companys = self::where('status',self::STATUS_VAILD)->get();
        if( $companys ){
            if( $format ){
                foreach( $companys as $company ){
                    $tmp[] = [
                        'label' => $company->name,
                        'value' => $company->getKey(),
                    ];
                }
                return $tmp;
            }else{
                return $companys;
            }
        }else{
            return [];
        }
    }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function formatRegion(){
        return Region::formatRegion($this->province_id,$this->city_id,$this->county_id);
    }
}
