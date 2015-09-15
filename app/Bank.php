<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    // protected $table="banks";
    protected $fillable = ['name','is_rec','day','sort','icon'];
    public $timestamps = false;
}
