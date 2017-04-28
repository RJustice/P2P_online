<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'borrowers';
    public $timestamps = false;

    protected $fillable = ['name','idno','repay_start','repay_end','loan','use','is_deleted','periods'];
}
