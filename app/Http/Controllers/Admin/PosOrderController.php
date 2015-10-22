<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\DealOrder;
use App\UserMoneyLog;
use Form;

class PosOrderController extends BaseController
{
    function __construct()
    {
        parent::__construct('posorders', 'POS订单');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $results['columns'] = [
            ['编号', 'order_sn',function($order_sn){
                return '<a href="'.route('admin.posorders.show',['sn'=>$order_sn]).'" title="查看投资详情">'.$order_sn.'</a>';
            }],
            ['投资项目','deal',function($deal){
                return '<a href="'.route('admin.deals.show',['id'=>$deal->getKey()]).'" title="查看投资项目">'.$deal->title.'</a>';
            }],
            ['理财金额','total_price',function($total_price){
                return '<span style="font-weight: 600;color:#ff5a13;letter-spacing: 1px;">' . number_format($total_price,2) . '</span>';
            }],
            ['客户','member',function($member){
                return '<a href="'.route('admin.members.show',['id'=>$member->getKey()]).'" title="查看用户">'.$member->formatInfo(). '</a>';
            }],
            ['起始时间','Model',function($model){
                return time() > strtotime($model->finish_date) ? '<span class="label label-danger">到期</span>' : $model->create_date .' ~ '.$model->finish_date;
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
        ];
        $paginate = DealOrder::with(['member'])->where('type',DealOrder::TYPE_POST_INVEST)->where('is_deleted',0);
        
        if( auth()->user()->hasRole('employee') ){
            $paginate->where('who_sale',auth()->user()->getKey());
        }elseif( auth()->user()->hasRole('employee_m') ){
            $paginate->where('company_id',auth()->user()->company_id);
        }
        $paginate->orderByRaw('id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate();
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate();
        }
        $results['items'] = $paginate->appends($all);
        // $panel_title = '投资订单列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($sn)
    {
        $data = DealOrder::where('order_sn',$sn)->first();
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
            return redirect()->route('admin.posorders.show',['sn'=>$sn])->withErrors(['default'=>"操作失败!"]);
        }

        if( $dealOrder->status != DealOrder::STATUS_PENDING ){
            return redirect()->route('admin.posorders.show',['sn'=>$sn])->withErrors(['default'=>'已经由 '.$dealOrder->whoConfirm->name.' 审核过']);
        }
        
        $posmoney = $request->get('posmoney');
        if( $posmoney < $dealOrder->total_price ){
            return redirect()->route('admin.posorders.show',['sn'=>$sn])->withErrors(['default'=>"请重新确认POS单金额,您填写的要比订单金额低!"]);
        }

        $whoConfirm = auth()->user();
        $dealOrder->status = $request->get('status');
        $dealOrder->who_confirm = $whoConfirm->getKey();
        $dealOrder->order_status = DealOrder::ORDER_STATUS_INVALID;
        $dealOrder->save();

        if( $dealOrder->status == DealOrder::STATUS_PASSED && $posmoney > $dealOrder->total_price ){
            $more = $posmoney - $dealOrder->total_price;

            $member = $dealOrder->member;

            $userMoneyLog = new UserMoneyLog();
            $userMoneyLog->user_id = $member->getKey();
            $userMoneyLog->money = $more;
            $userMoneyLog->account_money = $member->money + $more;
            $userMoneyLog->can_money = $member->can_money + $more;
            $userMoneyLog->type = UserMoneyLog::TYPE_POS_BALANCE;
            $userMoneyLog->created_at = date("Y-m-d H:i:s");
            $userMoneyLog->create_time_ymd = $dealOrder->create_date;
            $userMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
            $userMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
            $userMoneyLog->proof_id = 0 ;
            $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
            $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
            $userMoneyLog->save();

            // 用户资金变化
            $member->money = $member->money + $userMoneyLog->money;
            $member->can_money = $member->can_money + $more;
            $member->save();

        }

        // 操作记录
        // To-Do
        
        return redirect()->route('admin.posorders.show',['sn'=>$sn])->withErrors(['default'=>'审核成功']);
    }

}
