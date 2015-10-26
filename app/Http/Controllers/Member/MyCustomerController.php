<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\DealOrder;

class MyCustomerController extends Controller
{
    protected $member = '';

    public function __construct(){
        $this->member = auth()->user();
        $this->middleware('employee');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $customers = User::with('dealOrders')->select('id','name','hash_id','phone')
            ->where('is_deleted',0)
            ->where('state','<>',\App\User::STATE_INVAILD)
            ->where('sales_manager',$this->member->getKey());
        $customers = $customers->paginate(20);
        return view('member.mycustomer.index',compact('customers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $customer = User::where('hash_id',$id)->where('sales_manager',$this->member->getKey())->first();
        if( ! $customer ){
            return view('member.errors.noaccessuser');
        }
        $dealOrders = $customer->dealOrders()
            ->whereIn('type',[DealOrder::TYPE_OFFLINE_ORDER,DealOrder::TYPE_ONLINE_ORDER,DealOrder::TYPE_POS_INVEST])
            ->where('status','<>',DealOrder::STATUS_NOT_PASSED)
            ->get();
        return view('member.mycustomer.show',compact('customer','dealOrders'));
    }

}
