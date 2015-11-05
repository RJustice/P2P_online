<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
// use App\Deal;
use App\DealOrder;
// use App\DealOrderItem;
use App\User;
use App\UserMoneyLog;
use App\UserLockMoneyLog;
use App\Proof;
use Form;
use Storage;
// use Hashids;

class CheckController extends Controller
{
    protected $columns = [];

    function __construct(){
        parent::__construct('check','审核操作');
        $this->columns = $this->setColumns();
    }

    protected function setColumns(){
        return [
            // ['ID', 'id'],
            ['编号', 'order_sn',function($order_sn){
                return '<a href="'.route('admin.check.show',['sn'=>$order_sn]).'">'.$order_sn.'</a>';
            }],
            ['金额','total_price',function($total_price){
                return number_format($total_price,2);
            }],
            ['类型','type',function($type){
                return DealOrder::getOrderTypeTitle($type);
            }],
            ['客户','Model3',function($model){
                return $model->member->name .' - '. $model->member->phone;
            }],
            ['提交人员','Model1',function($model){
                // dd($model);
                return $model->whoSales->name;
            }],
            ['审核状态','status',function($status){
                switch($status){
                    case DealOrder::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case DealOrder::STATUS_NOT_PASSED :
                        $style = 'label-danger';
                        break;
                    case DealOrder::STATUS_PENDING :
                        $style = 'label-info';
                        break; 
                }
                return '<span class="label '.$style.'">'.DealOrder::getPassStatusTitle($status).'</span>';
            }],
            ['审核人员','Model2',function($model){
                return $model->whoConfirm ? $model->whoConfirm->name : '暂无';
            }]
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $results['columns'] = $this->columns;
        $paginate = DealOrder::with(['whoSales','whoConfirm'])->whereIn('type',[DealOrder::TYPE_OFFLINE_ORDER,DealOrder::TYPE_OFFLINE_RECHARGE,DealOrder::TYPE_HAND_FREEZE,DealOrder::TYPE_HAND_DEBIT])->where('is_deleted',0);
        $paginate->orderByRaw('status desc,id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('mobile', 'LIKE', '%'.$value.'%')->where('user_name','LIKE','%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = ' 审核列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results','panel_title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($sn)
    {
        $data = DealOrder::with('whoSales','whoConfirm','company')->where('order_sn',$sn)->first();
        if( $data ){
            return view('forone::'.$this->uri.'.show',compact('data'));
        }else{
            return $this->toIndex('数据未找到');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $sn)
    {
        $dealOrder = DealOrder::where('order_sn',$sn)->where('id',$request->get('id'))->first();
        if( ! $dealOrder ){
            return redirect()->route('admin.check.show',['sn'=>$sn])->withErrors(['default'=>"操作失败!"]);
        }

        if( $dealOrder->status != DealOrder::STATUS_PENDING ){
            return redirect()->route('admin.check.show',['sn'=>$sn])->withErrors(['default'=>'已经由 '.$dealOrder->whoConfirm->name.' 审核过']);
        }
        
        $whoConfirm = auth()->user();
        $dealOrder->status = $request->get('status');
        $dealOrder->who_confirm = $whoConfirm->getKey();
        $dealOrder->save();

        // 操作记录
        // To-Do
        
        return redirect()->route('admin.check.show',['sn'=>$sn])->withErrors(['default'=>'审核成功']);
    }

    public function freeze(Request $request){
        $results['columns'] = $this->columns;
        $paginate = DealOrder::with(['whoSales','whoConfirm'])->where('type',DealOrder::TYPE_HAND_FREEZE)->where('is_deleted',0);
        $paginate->orderByRaw('status desc,id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('mobile', 'LIKE', '%'.$value.'%')->where('user_name','LIKE','%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = '冻结资金  待审核列表';
        return $this->view('forone::' . $this->uri.'.index', compact('results','panel_title'));
    }

    public function recharge(Request $request){
        $results['columns'] = $this->columns;
        $paginate = DealOrder::with(['whoSales','whoConfirm'])->where('type',DealOrder::TYPE_OFFLINE_RECHARGE)->where('is_deleted',0);
        $paginate->orderByRaw('status desc,id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('mobile', 'LIKE', '%'.$value.'%')->where('user_name','LIKE','%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = '快速充值  待审核列表';
        return $this->view('forone::' . $this->uri.'.index', compact('results','panel_title'));
    }

    public function debit(Request $request){
        $results['columns'] = $this->columns;
        $paginate = DealOrder::with(['whoSales','whoConfirm'])->where('type',DealOrder::TYPE_HAND_DEBIT)->where('is_deleted',0);
        $paginate->orderByRaw('status desc,id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('mobile', 'LIKE', '%'.$value.'%')->where('user_name','LIKE','%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = '快速扣款  待审核列表';
        return $this->view('forone::' . $this->uri.'.index', compact('results','panel_title'));
    }

    public function offline(Request $request){
        $results['columns'] = $this->columns;
        $paginate = DealOrder::with(['whoSales','whoConfirm'])->where('type',DealOrder::TYPE_OFFLINE_ORDER)->where('is_deleted',0);
        $paginate->orderByRaw('status desc,id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('mobile', 'LIKE', '%'.$value.'%')->where('user_name','LIKE','%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = '线下订单登记  待审核列表';
        return $this->view('forone::' . $this->uri.'.index', compact('results','panel_title'));
    }
}
