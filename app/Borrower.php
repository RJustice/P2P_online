<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'borrowers';
    public $timestamps = false;

    protected $fillable = ['name','idno','repay_start','repay_end','loan','use','is_deleted','periods'];

    public function formatInfo(){
        return $this->name . ' - ' . preg_replace('/([0-9]{5})[0-9]{9}([0-9]{4}|[0-9]{3}X)/i','$1****$2',$this->idno);
    }
}
