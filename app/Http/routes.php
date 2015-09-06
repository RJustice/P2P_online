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
Route::get('/','HomeController@index');

// Route::group(['prefix' => 'demo'],function(){
//     Route::get('/',function(){
//         return view('demo.index');
//     });
//     Route::get('about',function(){
//         return view('demo.about');
//     });
//     Route::get('article/{id?}',function(){
//         return view('demo.article');
//     });
//     Route::get('project/{id?}',function(){
//         return view('demo.project');
//     });
//     Route::get('articles',function(){
//         return view('demo.articles');
//     });
// });

Route::controllers([
    'admin/auth' => 'Auth\AdminAuthController',
    'member/auth' => 'Auth\MemberAuthController',
]);
Route::get('member/confirm','Auth\MemberAuthController@getRegisterStep2');

Route::get('member/password/forget',['as'=>'password.forget','uses'=>'Auth\MemberPasswordController@forget']);

Route::get('member/finish',function(){
    return view('member.finish');
});

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => ['admin.auth']],function(){
    Route::group(['namespace' => 'Permissions'],function(){
        Route::resource('roles','RolesController');
        Route::resource('permissions','PermissionsController');
        Route::resource('admins','AdminsController');
        Route::post('roles/assign-permission', ['as' => 'admin.roles.assign-permission', 'uses' => 'RolesController@assignPermission']);
        Route::post('admins/assign-role', ['as' => 'admin.roles.assign-role', 'uses' => 'AdminsController@assignRole']);
    });
    Route::get('/','DashboardController@index');
    Route::get('category/alists',['as' => 'admin.category.alists','uses' => 'CategoryController@alists']);
    Route::resource('section','SectionController');
    Route::resource('category','CategoryController');
    Route::resource('pages','PagesController');
    Route::resource('articles','ArticlesController');
    Route::get('category/alists/{id}/edit','ArticlesController@edit');
});


// Route::get('articles','ArticlesController@index');
Route::get('articles/c/{cid}','ArticlesController@clist');
Route::get('articles/{id}','ArticlesController@show');
// Route::get('pages','PagesController@index');
Route::get('pages/{id}','PagesController@show');
Route::any('projects',function(){
    return view('projects');
});

Route::group(['prefix'=>'center','namespace'=>'Member','middleware' => ['member.auth']],function(){
    Route::get('/','CenterController@index');
});