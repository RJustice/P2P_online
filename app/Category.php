<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Section;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name','description','ordering','alias','parent_id'];
    protected $hidden = ['alias'];

    public function section(){
        return $this->hasOne('App\Section','section_id','id');
    }

    public function articles(){
        return $this->hasMany('App\Article','categoryid','id');
    }

    public static function getCategoriesOptions(){
        $cats = self::all();
        if( $cats ){
            foreach( $cats as $cat ){
                $return[] = [
                    'label' => $cat->name,
                    'value' => $cat->id
                ];
            }
            return $return;
        }else{
            return [];
        }
    }
}