<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;
use App\Article;
use Redirect, Input;
class PagesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {   
        $page = Page::where('id',$id)->where('type',Page::TYPE_PAGE)->where('published',1)->where('deleted','<>',true)->first();
        if( ! $page ){
            abort(404); 
        }
        if( !empty($page->out_link) ){
            return redirect($page->out_link);
        }
        $pages = Page::where('type',Article::TYPE_PAGE)->where('published',1)->where('deleted','<>',true)->orderBy('ordering','desc')->get();
        return view('pages.show',compact('page','pages','id'));
    }

    public function aliasShow($alias){
        $page = Page::where('alias',$alias)->where('type',Page::TYPE_PAGE)->where('published',1)->where('deleted','<>',true)->first();
        if( ! $page ){
            abort(404); 
        }
        if( !empty($page->out_link) ){
            return redirect($page->out_link);
        }
        $pages = Page::where('type',Article::TYPE_PAGE)->where('published',1)->where('deleted','<>',true)->orderBy('ordering','desc')->get();
        return view('pages.show',compact('page','pages'));
    }
}
