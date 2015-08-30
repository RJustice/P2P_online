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
        $page = Page::where('type',Page::TYPE_PAGE)->where('published',1)->firstOrFail();
        $pages = Page::where('type',Article::TYPE_PAGE)->where('published',1)->orderBy('id','desc')->get();
        return view('pages.show',compact('page','pages','id'));
    }
}