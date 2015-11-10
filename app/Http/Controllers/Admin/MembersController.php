<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserMeta;
use App\DealOrder;
use Form;
use Hashids;
use Validator;

class MembersController extends Controller
{

    function __construct()
    {
        parent::__construct('members', '客户');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $results = [
            'columns' => [
                ['ID', 'id'],
                ['姓名', 'name'],
                ['手机号','phone'],
                ['身份证号', 'idno'],
                // ['注册时间', 'created_at'],
                ['业务员','salesManager',function($salesManager){
                    if( $salesManager ){
                        return $salesManager->name;
                    }else{
                        return "暂无";
                    }
                }],
                ['区域','Model1',function($model){
                    return $model->formatRegion();
                }],
                // ['禁用状态','sModel',function($sModel){
                //     if( $sModel['published'] ){
                //         $btn_conf = ['name'=>'是','class'=>'btn-success','uri'=>$sModel['id'],'method'=>'POST','id'=>$sModel['id']];
                //         $btn_data = ['published'=>0];
                //     }else{
                //         $btn_conf = ['name'=>'否','class'=>'btn-danger','uri'=>$sModel['id'],'method'=>'POST','id'=>$sModel['id']];
                //         $btn_data = ['published'=>1];
                //     }
                //     return Form::form_button($btn_conf,$btn_data);
                // }],
                ['操作','Model',function($model){
                    if( Auth::user()->can(['member_all','member_u','admin']) ){
                        // $memberCtrl = '<li><a href="#" class="btn btn-block btn-warning">禁用</a></li>
                        //         <li><a href="#" class="btn btn-block btn-danger">删除</a></li>';
                        $memberCtrl = '';
                    }else{
                        $memberCtrl = '';
                    }
                    if( $model->sales_manager != 0 ){
                        $refBtn = Form::iform_button(['name'=>'转移客户','class'=>'btn btn-block btn-danger','uri'=>'remove-ref','method'=>'POST','id'=>$model->getKey()],[]);
                    }elseif( Auth::user()->can(['member_rm','admin']) ){
                        $refBtn = Form::iform_button(['name'=>'分配客户','class'=>'btn btn-block btn-danger','uri'=>$model->getKey().'#add-ref','method'=>'GET'],[]);;
                    }else{
                        $refBtn = '';
                    }
                    $viewBtn = '<a href="'.route('admin.'.$this->uri.'.show',['id'=>$model->getKey()]).'" class="btn btn-block btn-info">查看详情</a>';
                    return '<div class="dropdown">
                              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                操作
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                <li>'.$viewBtn.'</li>
                                <li><a href="'.route('admin.'.$this->uri.'.edit',['id'=>$model->getKey()]).'" class="btn btn-block btn-primary">编辑客户</a></li>
                                '.$memberCtrl.'
                                <li role="separator" class="divider"></li>
                                <li><a href="'.route("admin.hand.{id}.offline",['id'=>$model->getKey()]).'" class="btn btn-block btn-info">线下投资登记</a></li>
                                <li role="separator" class="divider"></li>
                                <li>'.$refBtn.'</li>
                              </ul>
                            </div>';
                }],
                // ['操作', 'buttons', function ($data) {
                //     $buttons = [
                //         ['编辑'],
                //         [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['deleted'=>1]],
                //         [['name'=>'查看','class'=>'btn-info','uri'=>$data['id'],'method'=>'GET'],[]]
                //     ];
                //     return $buttons;
                // }],
            ]
        ];
        $paginate = User::whereIn('type',[User::TYPE_MEMBER,User::TYPE_EMPLOYEE]);
        if( Auth::user()->type == User::TYPE_EMPLOYEE ){
            $paginate->where('sales_manager',Auth::user()->getKey());
        }
        $paginate->orderBy('id','desc');

        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('phone', 'LIKE', '%'.$value.'%');
                }
                // else{
                //     //可以根据不同的检索条件的不同值进行不同的语句组合，比如状态为7的数据加多筛选条件
                //     if ($key == 'status' && $value == 7) {
                //         $paginate->where($key, '=', 1)
                //                 ->where('time', '<', Carbon::now())
                //                 ->whereRaw(' `a` > `b` ')
                //                 ->orWhere($key, '=', $value);
                //     } else { //正常来说就只加where即可
                //         $paginate->where($key, '=', $value);
                //     }
                // }
            }
            $paginate = $paginate->paginate(15);
        }
        $results['items'] = $paginate->appends($all);

        return $this->view('forone::' . $this->uri.'.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = new User();
        return $this->view('forone::'.$this->uri.'.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['phone','name','password','is_deleted','idno','province_id','city_id','county_id','address','sales_manager','sex','type']);
        // $data['password'] = bcrypt($data['password']);
        $data['password'] = bcrypt('123456');
        $data['type'] = User::TYPE_MEMBER;
        $data['idcardpassed'] = 1;
        $data['idcardpassed_time'] = time();
        $data['hash_id'] = Hashids::encode();
        // $createUser = Auth::user();
        // if( $createUser->type == User::TYPE_ADMIN ){
            // $data['state'] = User::STATE_SYS_CREATED;    
        // }else{
            $data['state'] = User::STATE_SYS_CREATED;
        // }
        
        $data['phonepassed'] = 1;
        $data['address'] = empty($data['address'])?'':$data['address'];
        $createUser = Auth::user();
        if( $createUser->type == User::TYPE_ADMIN ){
            $data['referer'] = User::REFERER_SYSTEM;
        }else{
            $data['referer'] = User::REFERER_SALES_CREATED;
            $data['sales_manager'] = $createUser->getKey();
        }
        $data['modified_uid'] = Auth::user()->getKey();

        $data['username'] = $data['phone'];

        $validator = Validator::make($data, [
            'phone' => 'required|unique:users',
            'name' => 'required',
            'idno' => 'required|unique:users',            
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|max:20',
        ]);
        if( $validator->fails() ){
            return redirect()->route('admin.'.$this->uri.'.create')->withErrors($validator);
        }
        User::create($data);
        return redirect()->route('admin.'.$this->uri.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {   
        $data = User::find($id);        
        if( $data ){
             $dealOrders = [
                'columns' =>[
                    ['编号','order_sn'],
                    ['理财项目','deal_title'],
                    ['利率','deal_rate',function($deal_rate){
                        return $deal_rate . ' %';
                    }],
                    ['购买金额','total_price',function($total_price){
                        return number_format($total_price,2);
                    }],
                    ['开始时间','create_date'],
                    ['结束时间','finish_date',function($finish_date){
                        return $finish_date;
                    }],
                    // ['来源','referer'],
                ]
            ];
            $dealsPaginate = $data->dealOrders()->whereIn('type',[DealOrder::TYPE_OFFLINE_ORDER,DealOrder::TYPE_ONLINE_ORDER,DealOrder::TYPE_POS_INVEST])->where('is_deleted',0)->where('status',DealOrder::STATUS_PASSED)->orderByRaw('create_date desc')->paginate(15);
            $dealOrders['items'] = $dealsPaginate;
            return view('forone::'.$this->uri.'.show',compact('data','dealOrders'));
        }else{
            return $this->redirectWithError('数据未找到');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        if ($data) {
            return $this->view('forone::' . $this->uri. "/edit", compact('data'));
        }else{
            return $this->redirectWithError('数据未找到');
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
        $user = User::findOrFail($id);
        $data = $request->only(['phone','name','email','is_deleted','idno','province_id','city_id','county_id','address','sales_manager','sex','type']);
        if( isset($data['is_deleted']) && $data['is_deleted'] == 1 ){
            $user->username = 'D_'.$user->username;
            $user->phone = 'D_'.$user->phone;
            $user->idno = 'D_'.$user->idno;
            $user->is_deleted = 1;
            $user->save();
            return redirect()->route('admin.'.$this->uri.'.index');
        }
        $data['modified_uid'] = Auth::user()->getKey();
        $user->update($data);
        return redirect()->route('admin.'.$this->uri.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }

    public function removeRef(Request $request){
        if( Auth::user()->can(['member_c','admin']) ){
            $id = $request->get('id');
            $user = User::where('id',$id);
            if( auth()->user()->hasRole('employee') ){
                $user = $user->where('sales_manager',auth()->user()->getKey());
            }
            $user = $user->first();
            if( $user ){
                $user->sales_manager = 0;
                $user->save();
                return $this->toIndex('转移成功,请通知主管分配客户');
            }else{
                return $this->redirectWithError('无权转移这个客户,因这您不是该客户销售经理或未找到该客户信息');
            }
        }
    }

    public function addRef(Request $request){
        $auth = auth()->user();
        if( $auth->hasRole('admin') || $auth->hasRole('employee_m') ){
            $member = User::where('id',$request->get('uid'));
            $salesManager = User::where('id',$request->get('sales_manager'));
            if( $auth->hasRole('employee_m') ){
                $member = $member->where('company_id',$auth->company_id);
                $salesManager = $salesManager->where('company_id',$auth->company_id);
            }
            $member = $member->first();
            $salesManager = $salesManager->first();

            if( ! $member || ! $salesManager ){
                return redirect()->back()->withErrors(['default'=>'未选择销售经理.']);
            }

            $member->sales_manager = $salesManager->getKey();
            $member->save();
        }else{
            return redirect()->back()->withErrors(['default'=>'您无权执行该操作,需请示有主管权限员工操作']);
        }
        return redirect()->back()->withErrors(['default'=>'分配完成,将客户：'.$member->name.' 分配给销售：'.$salesManager->name]);
    }

    public function getReset(){
        return view('forone::'.$this->uri.'.reset');
    }

    public function postReset(Request $request){

    }
}
