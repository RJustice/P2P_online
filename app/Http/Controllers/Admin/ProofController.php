<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
// use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Proof;
use Form;
use Request;

class ProofController extends Controller
{
    public function __construct(){
        parent::__construct('proof','单据');
    }

    public function ajaxUpload(){
        dd(Request::file('proofs'));
    }
}
