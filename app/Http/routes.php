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
// Route::get('testsms',function(){
//     return var_dump(Sms::send());
// });
Route::get('youxiang',function(){
    return redirect('http://qiye.163.com/login/?from=ym');
});
Route::get('/','HomeController@index');
// Route::get('/',function(){
//     return \App\Article::find(1);
// });

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

// Route::get('member',function(){
//     return redirect('member/auth/login');
// });

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
    Route::resource('recruit','RecruitController');
    Route::resource('articles','ArticlesController');
    Route::resource('deals','DealsController');
    Route::resource('money','MoneyController');
    Route::resource('logs','LogsController');
    Route::resource('company','CompanyController');
    Route::get('category/alists/{id}/edit','ArticlesController@edit');

    Route::resource('users','UserManagerController');
    Route::post('users/remove-ref',['as' => 'admin.users.remove-ref','uses' => 'UserManagerController@removeRef']);
    // Route::get('users/get-add-ref',['as' => 'admin.users.get-add-ref','uses' => 'UserManagerController@getAddRef']);
    // Route::post('users/add-ref',['as' => 'admin.users.get-add-ref','uses' => 'UserManagerController@getAddRef']);
    Route::resource('employee','EmployeeController');

    // HandController
    Route::get('hand/add-order/{$id}',['as'=>'admin.hand.addorder','uses'=>'HandController@getAddOrder'])->where(['id'=>'[0-9]+']);
});


// Route::get('articles','ArticlesController@index');
Route::get('articles/c/{cid}','ArticlesController@clist');
Route::get('articles/{id}','ArticlesController@show');
// Route::get('pages','PagesController@index');
Route::get('pages/{id}','PagesController@show')->where(['id'=>'[0-9]+']);
Route::get('pages/{alias}','PagesController@aliasShow')->where(['alias' => '[A-Za-z_-]+']);

Route::get('recruit/{id}','RecruitController@show')->where(['id'=>'[0-9]+']);
Route::get('recruit/{alias}','RecruitController@aliasShow')->where(['alias' => '[A-Za-z_-]+']);

Route::any('projects',function(){
    return view('projects');
});

Route::group(['prefix'=>'member','namespace'=>'Member','middleware' => ['member.auth']],function(){
    Route::get('/','CenterController@index');
});

Route::group(['prefix'=>'invest','namespace'=>'Invest','middleware'=>['member.auth']],function(){
    Route::get('/','InvestController@index');
});

Route::post('sms/send','SmsController@postSendCode');

Route::get('count/{type?}','CountController@index');

Route::get('contact',function(){
    // $pages = \App\Page::where('type',\App\Article::TYPE_PAGE)->where('published',1)->orderBy('ordering','desc')->get();
    // $id = 2;
    return view('single.ditu');
});
Route::get('gltd',function(){
    $pages = \App\Page::where('type',\App\Article::TYPE_PAGE)->where('published',1)->where('deleted','<>',true)->orderBy('ordering','desc')->get();
    $id = 10;
    return view('single.gltd',compact('pages','id'));
});