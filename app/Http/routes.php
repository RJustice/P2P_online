<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/',function(){
    return view('welcome');
});

Route::group(['prefix' => 'demo'],function(){
    Route::get('/',function(){
        return view('demo.index');
    });
    Route::get('about',function(){
        return view('demo.about');
    });
    Route::get('article/{id?}',function(){
        return view('demo.article');
    });
    Route::get('project/{id?}',function(){
        return view('demo.project');
    });
    Route::get('articles',function(){
        return view('demo.articles');
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function(){
    Route::get('/','AdminHomeController@index');
    Route::resource('article','ArticleController');
    Route::resource('section','SectionController');
    Route::resource('category','CategoryController');
});

Route::get('article/{id}','ArticleController@show');
Route::get('category/{id}','CategoryController@show');
Route::get('project/{id}',function(){
    return 'wating soon...';
});
