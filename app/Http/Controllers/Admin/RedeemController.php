<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\DealOrder;
use App\UserMoneyLog;
use App\OrderToRedeem;
use Form;

class RedeemController extends BaseController
{
    function __construct()
    {
        parent::__construct('redeem', 'POS订单');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $results['columns'] = [
            ['编号', 'id',function($id){
                return '<a href="'.route('admin.redeem.show',['id'=>$id]).'" title="查看详情">'.$id.'</a>';
            }],
            ['投资项目','dealOrder',function($dealOrder){
                return '<a href="'.route('admin.deals.show',['id'=>$dealOrder->deal_id]).'" title="查看投资项目">'.$dealOrder->deal_title.'</a>';
            }],
            ['理财金额','order_money',function($order_money){
                return '<span style="font-weight: 600;color:#ff5a13;letter-spacing: 1px;">' . number_format($order_money,2) . '</span>';
            }],
            ['客户','user',function($user){
                return '<a href="'.route('admin.members.show',['id'=>$user->getKey()]).'" title="查看用户">'.$user->formatInfo(). '</a>';
            }],
            ['申请时间','Model2',function($model){
                return $model->created_at->format('Y-m-d');
            }],
            ['审核状态','Model3',function($model){
                switch($model->status){
                    case OrderToRedeem::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case OrderToRedeem::STATUS_UNPASSED :
                        $style = 'label-danger';
                        break;
                    case OrderToRedeem::STATUS_PENDING :
                        $style = 'label-info';
                        break; 
                }
                return '<a href="'.route('admin.redeem.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.OrderToRedeem::getPassStatusTitle($model->status).'</span></a>';
            }],
        ];
        $paginate = OrderToRedeem::with(['user','dealOrder'])->where('status',OrderToRedeem::STATUS_PENDING)->orderByRaw('status asc,id desc')->paginate();
        
        // $all = $request->except(['page']);
        // if (!sizeof($all)) {
        //     $paginate = $paginate->paginate();
        // }else{
        //     //遍历筛选条件
        //     foreach ($all as $key => $value) {
        //         if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
        //             $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
        //         }
        //     }
        //     $paginate = $paginate->paginate();
        // }
        // $results['items'] = $paginate->appends($all);
        $results['items'] = $paginate;
        // $panel_title = '投资订单列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results'));
    }

    public function show($id)
    {
        $data = OrderToRedeem::find($id);
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
    public function update(Request $request, $id)
    {
        $orderToRedeem = OrderToRedeem::find($id);
        if( ! $orderToRedeem ){
            return redirect()->route('admin.redeem.show',['id'=>$id])->withErrors(['default'=>"操作失败!"]);
        }

        if( $orderToRedeem->status != OrderToRedeem::STATUS_PENDING ){
            return redirect()->route('admin.redeem.show',['id'=>$id])->withErrors(['default'=>'已经由 '.$orderToRedeem->whoConfirm->name.' 审核过']);
        }
        
        $whoConfirm = auth()->user();
        $orderToRedeem->status = $request->get('status');
        $orderToRedeem->who_confirm = $whoConfirm->getKey();
        $orderToRedeem->save();

        // 操作记录
        // To-Do
        
        return redirect()->route('admin.redeem.show',['id'=>$id])->withErrors(['default'=>'审核成功']);
    }

    public function passed(Request $request){
        $results['columns'] = [
            ['编号', 'id',function($id){
                return '<a href="'.route('admin.redeem.show',['id'=>$id]).'" title="查看详情">'.$id.'</a>';
            }],
            ['投资项目','dealOrder',function($dealOrder){
                return '<a href="'.route('admin.deals.show',['id'=>$dealOrder->deal_id]).'" title="查看投资项目">'.$dealOrder->deal_title.'</a>';
            }],
            ['理财金额','order_money',function($order_money){
                return '<span style="font-weight: 600;color:#ff5a13;letter-spacing: 1px;">' . number_format($order_money,2) . '</span>';
            }],
            ['客户','user',function($user){
                return '<a href="'.route('admin.members.show',['id'=>$user->getKey()]).'" title="查看用户">'.$user->formatInfo(). '</a>';
            }],
            ['申请时间','Model2',function($model){
                return $model->created_at->format('Y-m-d');
            }],
            ['审核状态','Model3',function($model){
                switch($model->status){
                    case OrderToRedeem::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case OrderToRedeem::STATUS_UNPASSED :
                        $style = 'label-danger';
                        break;
                    case OrderToRedeem::STATUS_PENDING :
                        $style = 'label-info';
                        break; 
                }
                return '<a href="'.route('admin.redeem.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.OrderToRedeem::getPassStatusTitle($model->status).'</span></a>';
            }],
        ];
        $paginate = OrderToRedeem::with(['user','dealOrder'])->where('status',OrderToRedeem::STATUS_PASSED)->orderByRaw('status asc,id desc')->paginate();
        
        // $all = $request->except(['page']);
        // if (!sizeof($all)) {
        //     $paginate = $paginate->paginate();
        // }else{
        //     //遍历筛选条件
        //     foreach ($all as $key => $value) {
        //         if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
        //             $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
        //         }
        //     }
        //     $paginate = $paginate->paginate();
        // }
        // $results['items'] = $paginate->appends($all);
        $results['items'] = $paginate;
        // $panel_title = '投资订单列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results'));
    }

    public function unpassed(Request $request){
        $results['columns'] = [
            ['编号', 'id',function($id){
                return '<a href="'.route('admin.redeem.show',['id'=>$id]).'" title="查看详情">'.$id.'</a>';
            }],
            ['投资项目','dealOrder',function($dealOrder){
                return '<a href="'.route('admin.deals.show',['id'=>$dealOrder->deal_id]).'" title="查看投资项目">'.$dealOrder->deal_title.'</a>';
            }],
            ['理财金额','order_money',function($order_money){
                return '<span style="font-weight: 600;color:#ff5a13;letter-spacing: 1px;">' . number_format($order_money,2) . '</span>';
            }],
            ['客户','user',function($user){
                return '<a href="'.route('admin.members.show',['id'=>$user->getKey()]).'" title="查看用户">'.$user->formatInfo(). '</a>';
            }],
            ['申请时间','Model2',function($model){
                return $model->created_at->format('Y-m-d');
            }],
            ['审核状态','Model3',function($model){
                switch($model->status){
                    case OrderToRedeem::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case OrderToRedeem::STATUS_UNPASSED :
                        $style = 'label-danger';
                        break;
                    case OrderToRedeem::STATUS_PENDING :
                        $style = 'label-info';
                        break; 
                }
                return '<a href="'.route('admin.redeem.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.OrderToRedeem::getPassStatusTitle($model->status).'</span></a>';
            }],
        ];
        $paginate = OrderToRedeem::with(['user','dealOrder'])->where('status',OrderToRedeem::STATUS_UNPASSED)->orderByRaw('status asc,id desc')->paginate();
        
        // $all = $request->except(['page']);
        // if (!sizeof($all)) {
        //     $paginate = $paginate->paginate();
        // }else{
        //     //遍历筛选条件
        //     foreach ($all as $key => $value) {
        //         if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
        //             $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
        //         }
        //     }
        //     $paginate = $paginate->paginate();
        // }
        // $results['items'] = $paginate->appends($all);
        $results['items'] = $paginate;
        // $panel_title = '投资订单列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results'));
    }

    // public function cancel(Request $request){
    //     $results['columns'] = [
    //         ['编号', 'id',function($id){
    //             return '<a href="'.route('admin.redeem.show',['id'=>$id]).'" title="查看详情">'.$id.'</a>';
    //         }],
    //         ['投资项目','dealOrder',function($dealOrder){
    //             return '<a href="'.route('admin.deals.show',['id'=>$dealOrder->deal_id]).'" title="查看投资项目">'.$dealOrder->deal_title.'</a>';
    //         }],
    //         ['理财金额','order_money',function($order_money){
    //             return '<span style="font-weight: 600;color:#ff5a13;letter-spacing: 1px;">' . number_format($order_money,2) . '</span>';
    //         }],
    //         ['客户','user',function($user){
    //             return '<a href="'.route('admin.members.show',['id'=>$user->getKey()]).'" title="查看用户">'.$user->formatInfo(). '</a>';
    //         }],
    //         ['申请时间','Model2',function($model){
    //             return $model->created_at->format('Y-m-d');
    //         }],
    //         ['审核状态','Model3',function($model){
    //             switch($model->status){
    //                 case OrderToRedeem::STATUS_PASSED :
    //                     $style = 'label-success';
    //                     break;
    //                 case OrderToRedeem::STATUS_UNPASSED :
    //                     $style = 'label-danger';
    //                     break;
    //                 case OrderToRedeem::STATUS_PENDING :
    //                     $style = 'label-info';
    //                     break; 
    //             }
    //             return '<a href="'.route('admin.redeem.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.OrderToRedeem::getPassStatusTitle($model->status).'</span></a>';
    //         }],
    //     ];
    //     $paginate = OrderToRedeem::with(['user','dealOrder'])->orderByRaw('status asc,id desc')->paginate();
        
    //     // $all = $request->except(['page']);
    //     // if (!sizeof($all)) {
    //     //     $paginate = $paginate->paginate();
    //     // }else{
    //     //     //遍历筛选条件
    //     //     foreach ($all as $key => $value) {
    //     //         if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
    //     //             $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
    //     //         }
    //     //     }
    //     //     $paginate = $paginate->paginate();
    //     // }
    //     // $results['items'] = $paginate->appends($all);
    //     $results['items'] = $paginate;
    //     // $panel_title = '投资订单列表';
    //     return $this->view('forone::'.$this->uri.'.index', compact('results'));
    // }
}
