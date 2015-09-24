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
    Route::get('/',['as'=>'admin','uses'=>'DashboardController@index']);
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

    Route::patch('members/remove-ref',['as' => 'admin.members.remove-ref','uses' => 'MembersController@removeRef']);
    Route::post('members/add-ref',['as' => 'admin.members.get-add-ref','uses' => 'MembersController@addRef']);
    Route::get('members/{id}/orders',['as'=>'admin.members.{id}.orders','uses'=>'MembersController@orders']);
    Route::resource('members','MembersController');


    Route::resource('employee','EmployeeController');

    // HandController
    Route::group(['prefix'=>'hand/{id}'],function(){
        Route::get('recharge',['as'=>'admin.hand.{id}.recharge','uses'=>'HandController@getRecharge']);
        Route::post('recharge',['as'=>'admin.hand.{id}.recharge','uses'=>'HandController@postRecharge']);
        
        Route::get('freeze',['as'=>'admin.hand.{id}.freeze','uses'=>'HandController@getFreeze']);
        Route::post('freeze',['as'=>'admin.hand.{id}.freeze','uses'=>'HandController@postFreeze']);
        
        Route::get('debit',['as'=>'admin.hand.{id}.debit','uses'=>'HandController@getDebit']);
        Route::post('debit',['as'=>'admin.hand.{id}.debit','uses'=>'HandController@postDebit']);
        
        Route::get('offline',['as'=>'admin.hand.{id}.offline','uses'=>'HandController@getOffline']);
        Route::post('offline',['as'=>'admin.hand.{id}.offline','uses'=>'HandController@postOffline']);
    });

    // CheckController
    Route::group(['prefix' => 'check'],function(){

        Route::get('list',['as'=>'admin.check.list','uses'=>'CheckController@index']);
        Route::get('/',['as'=>'admin.check.index',function(){
            return redirect()->route('admin.check.list');
        }]);
        Route::get('recharge',['as'=>'admin.check.recharge','uses'=>'CheckController@recharge']);
        Route::get('freeze',['as'=>'admin.check.freeze','uses'=>'CheckController@freeze']);
        Route::get('debit',['as'=>'admin.check.debit','uses'=>'CheckController@debit']);
        Route::get('offline',['as'=>'admin.check.offline','uses'=>'CheckController@offline']);

        // Route::resource('','CheckController');
        Route::get('/{sn}',['as'=>'admin.check.show','uses'=>'CheckController@show']);
        Route::put('/{sn}',['as'=>'admin.check.update','uses'=>'CheckController@update']);
    });

    // Route::resource('dealorders','DealOrdersController');
    // Route::get('dealorders',['as'=>'admin.dealorders.index','uses'=>'DealOrdersController@index']);
    Route::get('dealorders/{sn}',['as'=>'admin.dealorders.show','uses'=>'DealOrdersController@show'])->where(['sn'=>'[A-Z]{2}_[0-9]{14}']);
    Route::get('dealorders/order',['as'=>'admin.dealorders.order','uses'=>'DealOrdersController@order']);
    Route::get('dealorders/recharge',['as'=>'admin.dealorders.recharge','uses'=>'DealOrdersController@recharge']);

    Route::post('proof/ajaxupload',['as'=>'admin.proof.ajaxUpload','uses'=>'ProofController@ajaxUpload']);
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


// proof
// ln -s /path/to/laravel/storage/avatars /path/to/laravel/public/avatars
// 
Route::get('proof/{filename}/{size}',['as'=>'proof',function($filename,$size){
    switch($size){
        case 'full':
            return Image::make(storage_path() .'\/app/'. implode('/', explode('_', $filename)))->response();
            break;
        case 'w350':
            return Image::make(storage_path() .'\/app/'. implode('/', explode('_', $filename)))->resize(350, null, function ($constraint) {$constraint->aspectRatio();})->response();
        case '200x200':
            return Image::make(storage_path() .'\/app/'. implode('/', explode('_', $filename)))->resize(200, 200)->response();
            break;
    }
}]);