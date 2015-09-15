<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    // protected $table = "regions";
    protected $fillable = ['id','pid','name','region_level'];
    public $timestamps = false;

    public function getProvince($county = 1,$format = false){
        $provinces = self::where('pid',$county)->where('region_level',2)->get();
        if( $format ){
            foreach( $provinces as $province ){
                $tmp[] = [
                    'label' => $province->name,
                    'value' => $province->id,
                ];
            }
            return $tmp;
        }else{
            return $provinces;
        }
    }

    public function getCity($province,$format = false){
        $citys = self::where('pid',$province)->where('region_level',3)->get();
        if( $format ){
            foreach( $citys as $city ){
                $tmp[] = [
                    'label' => $city->name,
                    'value' => $city->id,
                ];
            }
            return $tmp;
        }else{
            return $citys;
        }
    }

    public function getTown($city,$format = false){
        $towns = self::where('pid',$city)->where('region_level',4)->get();
        if( $format ){
            foreach( $towns as $town ){
                $tmp[] = [
                    'label' => $town->name,
                    'value' => $town->id,
                ];
            }
            return $tmp;
        }else{
            return $towns;
        }
    }

    // public function getZone($town,$format = false){
    //     $zones = self::where('pid',$town)->where('region_level',4)->get();
    //     if( $format ){
    //         foreach( $zones as $zone ){
    //             $tmp[] = [
    //                 'label' => $zone->name,
    //                 'value' => $zone->id,
    //             ];
    //         }
    //         return $tmp;
    //     }else{
    //         return $zones;
    //     }
    // }
}
