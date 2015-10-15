<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Contact;

class ContactController extends Controller
{
    public function index(){
        return view('contact.form');
    }

    public function licai(Request $request){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput($request->only('phone','title','msg'))
                ->withErrors($validator);
        }
        $contact = new Contact;
        $contact->title = $request->get('title');
        $contact->msg = $request->get('msg');
        $contact->phone = $request->get('phone');
        $contact->status = 0;
        $contact->type = 1;
        $contact->save();
        return redirect()->route('contact.success');
    }

    public function success(){
        return view('contact.success');
    }

    protected function validator(array $data)
    {   
        Validator::extend('check', function($attribute, $value, $parameters)
        {
            return captcha_check($value);
        });
        $v = Validator::make($data, [
            'phone'=>['required','regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'title' => ['required'],
            'vercode' => 'required|check'
        ]);
        // $v->sometimes('rec_user','required|exists:users,phone,type,'.User::TYPE_EMPLOYEE,function($request){
        //     return $request->get('rec_user');
        // });
        return $v;
    }
}
