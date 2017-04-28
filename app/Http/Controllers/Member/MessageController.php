<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    public function index()
    {
        // $messages = Message::where('user_id',auth()->user()->getKey())->get();
        return view('member.message.index');
    }

    public function deleteAll(Request $request){

    }
}
