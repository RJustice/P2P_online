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

Route::get('youxiang',function(){
    return redirect('http://qiye.163.com/login/?from=ym');
});
Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
Route::controllers([
    'admin/auth' => 'Auth\AdminAuthController',
    'member/auth' => 'Auth\MemberAuthController',
]);
Route::get('member/confirm','Auth\MemberAuthController@getRegisterStep2');

Route::get('member/password/forget',['as'=>'password.forget','uses'=>'Auth\MemberPasswordController@forget']);
Route::post('member/password/forget',['as'=>'password.forget','uses'=>'Auth\MemberPasswordController@postForget']);

Route::get('member/password/forgettwo',['as'=>'password.forgettwo','uses'=>'Auth\MemberPasswordController@forgetTwo']);
Route::post('member/password/forgettwo',['as'=>'password.forgettwo','uses'=>'Auth\MemberPasswordController@postForgetTwo']);


Route::get('member/finish',function(){
    return view('member.finish');
});

Route::get('sysreset',['as'=>'sysmember','uses'=>'MemberExtraController@getSysMemberResetPWD']);
Route::post('sysreset',['as'=>'sysmember','uses'=>'MemberExtraController@postSysMemberResetPWD']);

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
    Route::resource('dealexp','DealExpController');
    Route::resource('articles','ArticlesController');
    Route::resource('deals','DealsController');
    Route::resource('money','MoneyController');
    Route::resource('logs','LogsController');
    Route::resource('company','CompanyController');
    Route::resource('borrowers','BorrowerController');
    Route::resource('carrys','CarryController');
    Route::get('carrys-passed','CarryController@passed');
    Route::get('carrys-unpassed','CarryController@unpassed');
    Route::get('carrys-cancel','CarryController@cancel');
    Route::resource('contacts','ContactController');
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

        Route::get('redeem',['as'=>'admin.hand.{id}.redeem','uses'=>'HandController@getRedeem']);
        Route::post('redeem',['as'=>'admin.hand.{id}.redeem','uses'=>'HandController@postRedeem']);

        Route::get('memberorders',['as'=>'admin.hand.{id}.memberorders','use'=>'HandController@ajaxGetOrders']);
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

    Route::get('posorders',['as'=>'admin.posorders.index','uses'=>'PosOrderController@index']);
    Route::get('posorders/show/{sn}',['as'=>'admin.posorders.show','uses'=>'PosOrderController@show']);
    Route::put('posorders/{sn}',['as'=>'admin.posorders.update','uses'=>'PosOrderController@update']);

    Route::resource('redeem','RedeemController');    
    Route::get('redeem-passed','RedeemController@passed');
    Route::get('redeem-unpassed','RedeemController@unpassed');
    Route::get('redeem-cancel','RedeemController@cancel');
    // Route::get('redeem',['as'=>'admin.redeem.index','uses'=>'RedeemController@index']);
    // Route::get('redeem/show/{sn}',['as'=>'admin.redeem.show','uses'=>'RedeemController@show']);
    // Route::put('redeem/{sn}',['as'=>'admin.redeem.update','uses'=>'RedeemController@update']);
});


// Route::get('articles','ArticlesController@index');
Route::get('articles/c/{cid}','ArticlesController@clist');
Route::get('articles/{id}','ArticlesController@show');
// Route::get('pages','PagesController@index');
Route::get('pages/{id}','PagesController@show')->where(['id'=>'[0-9]+']);
Route::get('pages/{alias}','PagesController@aliasShow')->where(['alias' => '[A-Za-z_-]+']);

Route::get('recruit/{id}','RecruitController@show')->where(['id'=>'[0-9]+']);
Route::get('recruit/{alias}','RecruitController@aliasShow')->where(['alias' => '[A-Za-z_-]+']);

Route::get('dealexp/{id}','DealExpController@show')->where(['id'=>'[0-9]+']);

Route::any('projects',function(){
    return view('projects');
});

Route::group(['prefix'=>'member','namespace'=>'Member','middleware' => ['member.auth']],function(){
    Route::get('/',['as'=>'member','uses'=>'CenterController@index']);
    // Route::get('fund/recharge',['as'=>'member.fund.recharge','uses'=>'FundController@getRecharge']);
    // Route::post('fund/recharge',['as'=>'member.fund.recharge','uses'=>'FundController@postRecharge']);

    Route::get('fund/carry',['as'=>'member.fund.carry','uses'=>'FundController@getCarry']);
    Route::post('fund/carry',['as'=>'member.fund.carry','uses'=>'FundController@postCarry']);
    Route::get('fund/carrylogs',['as'=>'member.fund.carrylogs','uses'=>'FundController@carryLogs']);
    Route::post('fund/carry-cancel',['as'=>'member.fund.carrycancel','uses'=>'FundController@carryCancel']);

    // 赎回
    Route::get('fund/redeem/{id?}',['as'=>'member.fund.redeem.{id?}','uses'=>'FundController@getRedeem']);
    Route::post('fund/redeem',['as'=>'member.fund.redeem','uses'=>'FundController@postRedeem']);
    Route::get('fund/redeemlogs',['as'=>'member.fund.redeemlogs','uses'=>'FundController@redeemLogs']);
    
    Route::post('fund/redeem-cancel',['as'=>'member.fund.redeemcancel','uses'=>'FundController@redeemCancel']);


    Route::get('fund/summarydetail',['as'=>'member.fund.summarydetail','uses'=>'FundController@getSummaryDetail']);
    Route::get('fund/logs',['as'=>'member.fund.logs','uses'=>'FundController@getLogs']);

    Route::get('account/basic',['as'=>'member.account.basic','uses'=>'AccountController@getBasic']);
    Route::get('account/authenticate',['as'=>'member.account.authenticate','uses'=>'AccountController@getAuthenticate']);
    Route::get('account/bankcard',['as'=>'member.account.bankcard','uses'=>'AccountController@getBankcard']);
    Route::get('account/safe',['as'=>'member.account.safe','uses'=>'AccountController@getSafe']);
    Route::get('account/resetpwd',['as'=>'member.account.resetpwd','uses'=>'AccountController@getResetPWD']);
    
    Route::post('account/basic',['as'=>'member.account.basic','uses'=>'AccountController@postBasic']);
    Route::post('account/authenticate',['as'=>'member.account.authenticate','uses'=>'AccountController@postAuthenticate']);
    Route::post('account/bankcard',['as'=>'member.account.bankcard','uses'=>'AccountController@postBankcard']);
    Route::post('account/safe',['as'=>'member.account.safe','uses'=>'AccountController@postSafe']);
    Route::post('account/resetpwd',['as'=>'member.account.resetpwd','uses'=>'AccountController@postResetPWD']);
    
    Route::get('account/resetpay/{ctl}',['as'=>'member.account.resetpay.{ctl}','uses'=>'AccountController@getResetPay']);
    Route::post('account/resetpay',['as'=>'member.account.resetpay','uses'=>'AccountController@postResetPay']);

    // Route::get('account/resetphone/one',['as'=>'member.account.resetphone.one','uses'=>'AccountController@getResetPhoneOne']);
    // Route::get('account/resetphone/two',['as'=>'member.account.resetphone.two','uses'=>'AccountController@getResetPhoneTwo']);
    // Route::post('account/resetphone/one',['as'=>'member.account.resetphone.one','uses'=>'AccountController@postResetPhoneOne']);
    // Route::post('account/resetphone/two',['as'=>'member.account.resetphone.two','uses'=>'AccountController@postResetPhoneTwo']);

    Route::get('invest',['as'=>'member.invest.index','uses'=>'InvestController@index']);

    Route::resource('message','MessageController');

    // Route::resource('redpacket','RedpacketController');
    Route::get('redpacket/{status?}',['as'=>'member.redpacket','uses'=>'RedpacketController@index']);

    Route::resource('mycustomer','MyCustomerController');

});


Route::get('invest/checkmoney','InvestController@checkmoney');
Route::get('invest','InvestController@index');
Route::post('invest/doinvest','InvestController@doinvest');
Route::match(['post','put','patch'],'invest/posinvest','InvestController@posinvest');

Route::post('contact/licai','ContactController@licai');
Route::get('contact/success',['as'=>'contact.success','uses'=>'ContactController@success']);
Route::get('contact/jiekuan','ContactController@index');

Route::post('sms/send','SmsController@postSendCode');

Route::post('sms/test','SmsController@postTestSendCode');

Route::get('count/{type?}','CountController@index');

Route::get('contact',function(){
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