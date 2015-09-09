<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Category;

use Redirect, Input;
class ArticlesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('articles.show')->withArticle(Article::find($id));
    }

    public function clist($cid){
        $c = Category::findOrFail($cid);
        $cats = Category::where('published',1)->get();
        $articles = Article::where('type',Article::TYPE_NORMAL)
                            ->where('published',1)
                            ->where('categoryid',$cid)
                            ->orderBy('id','desc')
                            ->paginate(20);
        return view('articles.clist',compact('cats','articles','c'));
    }
}
