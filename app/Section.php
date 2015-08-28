<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $fillable = ['name','description','ordering'];

    protected $hidden = ['alias'];

    public function categories(){
        return $this->hasMany('App\Category','id','section_id');
    }

    public function getSectionsOptions(){
        return $this->all();
    }
}