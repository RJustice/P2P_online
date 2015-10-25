<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DealExp;
use App\Article;
use Redirect, Input;
class DealExpController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {   
        $page = DealExp::where('id',$id)->where('type',DealExp::TYPE_DEALEXP)->where('published',1)->where('deleted','<>',true)->first();
        if( ! $page ){
            abort(404); 
        }
        // if( !empty($page->out_link) ){
        //     return redirect($page->out_link);
        // }
        $pages = DealExp::where('type',Article::TYPE_DEALEXP)->where('published',1)->where('deleted','<>',true)->orderBy('ordering','desc')->get();
        return view('dealexp.show',compact('page','pages','id'));
    }

    public function aliasShow($alias){
        $page = DealExp::where('alias',$alias)->where('type',DealExp::TYPE_DEALEXP)->where('published',1)->where('deleted','<>',true)->first();
        if( ! $page ){
            abort(404); 
        }
        // if( !empty($page->out_link) ){
        //     return redirect($page->out_link);
        // }
        $pages = DealExp::where('type',Article::TYPE_DEALEXP)->where('published',1)->where('deleted','<>',true)->orderBy('ordering','desc')->get();
        return view('dealexp.show',compact('page','pages'));
    }
}
