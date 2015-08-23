<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use App\Category;
// use App\Section;

class Article extends Model
{
    public function category(){
        return $this->hasOne('App\Category','id','categoryid');
    }

    public function section(){
        return $this->hasOne('App\Section','id','sectionid');
    }
}
