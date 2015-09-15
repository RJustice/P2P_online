<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Recruit;
use App\Article;
use Redirect, Input;
class RecruitController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {   
        $page = Recruit::where('id',$id)->where('type',Recruit::TYPE_RECRUIT)->where('published',1)->first();
        if( ! $page ){
            abort(404); 
        }
        // if( !empty($page->out_link) ){
        //     return redirect($page->out_link);
        // }
        $pages = Recruit::where('type',Article::TYPE_RECRUIT)->where('published',1)->orderBy('ordering','desc')->get();
        return view('recruit.show',compact('page','pages','id'));
    }

    public function aliasShow($alias){
        $page = Recruit::where('alias',$alias)->where('type',Recruit::TYPE_RECRUIT)->where('published',1)->first();
        if( ! $page ){
            abort(404); 
        }
        // if( !empty($page->out_link) ){
        //     return redirect($page->out_link);
        // }
        $pages = Recruit::where('type',Article::TYPE_RECRUIT)->where('published',1)->orderBy('ordering','desc')->get();
        return view('recruit.show',compact('page','pages'));
    }
}
