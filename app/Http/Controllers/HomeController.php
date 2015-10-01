<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Category;
use Redirect, Input;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {        
        $official_news = Category::where('alias','official-news')->first()->articles()->orderBy('id','desc')->take(4)->get();
        $industry_news = Category::where('alias','industry-news')->first()->articles()->orderBy('id','desc')->take(4)->get();
        //$industry_news = Category::where('alias','industry-news')->get();
        return view('index',compact('official_news','industry_news'));
    }

}
