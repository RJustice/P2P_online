<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    protected $table = "loan_types";
    protected $guarded = [];    
    public $timestamps = false;
}
