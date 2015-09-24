<?php

namespace App\Http\Controllers\Admin;


use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Deal;
use App\DealOrder;
// use App\DealOrderItem;
use App\User;
// use App\UserMoneyLog;
// use App\UserLockMoneyLog;
// use App\Proof;
use Form;
class DealOrdersController extends Controller
{

    protected $columns = [];

    function __construct(){
        parent::__construct('dealorders','投资');
        // $this->columns = $this->setColumns();
    }

    protected function setColumns(){
        return [
            ['编号', 'order_sn',function($order_sn){
                return '<a href="'.route('admin.check.show',['sn'=>$order_sn]).'" title="查看投资详情">'.$order_sn.'</a>';
            }],
            ['投资项目','deal',function($deal){
                return '<a href="'.route('admin.deals.show',['id'=>$deal->getKey()]).'" title="查看投资项目">'.$deal->title.'</a>';
            }],
            ['理财金额','total_price',function($total_price){
                return number_format($total_price,2);
            }],
            ['客户','member',function($member){
                return '<a href="'.route('admin.members.show',['id'=>$member->getKey()]).'" title="查看用户">'.$member->formatInfo(). '</a>';
            }],
            ['起始时间','Model',function($model){
                return time() > strtotime($model->finish_date) ? '<span class="label label-danger">到期</span>' : $model->create_date .' ~ '.$model->finish_date;
            }],
            ['投资方式','type',function($type){
                return DealOrder::getOrderTypeTitle($type);
            }]
        ];
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($sn)
    {
        $salesMonager = auth()->user();
        $query = DealOrder::where('is_deleted',0)->where('order_sn',$sn);
        if( $salesMonager->hasRole('employee') ){
            $query->where('who_sale',$salesMonager->getKey());
        }elseif( $salesMonager->hasRole('employee_m') ){
            $query->where('company_id',$salesMonager->company_id);
        }
        $data = $query->first();

        if( ! $data ){
            return redirect()->route('admin.dealorders.order')->withErrors(['default'=>'未查找到相应数据']);
        }

        return view("forone::".$this->uri.'.show',compact('data'));
    }

    public function order(Request $request){
        // $results['columns'] = $this->columns;
        $results['columns'] = [
            ['编号', 'order_sn',function($order_sn){
                return '<a href="'.route('admin.dealorders.show',['sn'=>$order_sn]).'" title="查看投资详情">'.$order_sn.'</a>';
            }],
            ['投资项目','deal',function($deal){
                return '<a href="'.route('admin.deals.show',['id'=>$deal->getKey()]).'" title="查看投资项目">'.$deal->title.'</a>';
            }],
            ['理财金额','total_price',function($total_price){
                return number_format($total_price,2);
            }],
            ['客户','member',function($member){
                return '<a href="'.route('admin.members.show',['id'=>$member->getKey()]).'" title="查看用户">'.$member->formatInfo(). '</a>';
            }],
            ['起始时间','Model',function($model){
                return time() > strtotime($model->finish_date) ? '<span class="label label-danger">到期</span>' : $model->create_date .' ~ '.$model->finish_date;
            }],
            ['投资方式','type',function($type){
                return DealOrder::getOrderTypeTitle($type);
            }]
        ];
        $paginate = DealOrder::with(['member'])->whereIn('type',[DealOrder::TYPE_OFFLINE_ORDER,DealOrder::TYPE_ONLINE_ORDER])->where('is_deleted',0);
        
        if( auth()->user()->hasRole('employee') ){
            $paginate->where('who_sale',auth()->user()->getKey());
        }elseif( auth()->user()->hasRole('employee_m') ){
            $paginate->where('company_id',auth()->user()->company_id);
        }
        $paginate->orderByRaw('id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = '投资订单列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results','panel_title'));
    }

    public function recharge(Request $request){
        // $results['columns'] = $this->columns;
        $results['columns'] = [
            ['编号', 'order_sn',function($order_sn){
                return '<a href="'.route('admin.dealorders.show',['sn'=>$order_sn]).'" title="查看投资详情">'.$order_sn.'</a>';
            }],
            ['充值金额','total_price',function($total_price){
                return number_format($total_price,2);
            }],
            ['客户','member',function($member){
                return '<a href="'.route('admin.members.show',['id'=>$member->getKey()]).'" title="查看用户">'.$member->formatInfo(). '</a>';
            }],
            ['充值时间','create_date'],
            ['充值方式','type',function($type){
                return DealOrder::getOrderTypeTitle($type);
            }]
        ];
        $paginate = DealOrder::with(['member'])->whereIn('type',[DealOrder::TYPE_ONLINE_RECHARGE,DealOrder::TYPE_OFFLINE_RECHARGE])->where('is_deleted',0);
        
        if( auth()->user()->hasRole('employee') ){
            $paginate->where('who_sale',auth()->user()->getKey());
        }elseif( auth()->user()->hasRole('employee_m') ){
            $paginate->where('company_id',auth()->user()->company_id);
        }

        $paginate->orderByRaw('id desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('order_sn', 'LIKE', '%'.$value.'%');
                }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        $panel_title = '充值列表';
        return $this->view('forone::'.$this->uri.'.index', compact('results','panel_title'));
    }
}
