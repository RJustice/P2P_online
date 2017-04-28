<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\UserCarry;
use Form;


class CarryController extends BaseController
{
    function __construct()
    {
        parent::__construct('carrys', '提现申请');
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
                ['客户', 'Model1',function($model){
                    return $model->user->formatInfo();
                }],
                ['金额','money'],
                ['银行','Model2',function($model){
                    return $model->bank->name .' - ' . $model->bankzone;
                }],
                ['卡号','bank_card'],
                ['申请时间','created_at',function($created_at){
                    return $created_at->format('Y-m-d');
                }],
                ['状态','Model3',function($model){
                switch($model->status){
                    case UserCarry::STATUS_NOT_PASSED :
                        $style = 'label-danger';
                        break;
                    case UserCarry::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case UserCarry::STATUS_PENDING :
                        $style = 'label-info';
                        break;
                    case UserCarry::STATUS_CANCEL :
                        $style = 'label-default';
                        break;
                }
                return '<a href="'.route('admin.'.$this->uri.'.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.UserCarry::getStatusTitle($model->status).'</span></a>';
                    return ;
                }]
            ]
        ];
        $paginate = UserCarry::with(['user','bank'])->where('status',UserCarry::STATUS_PENDING)->orderBy('id','desc');
        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('bank_card', 'LIKE', '%'.$value.'%');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data = UserCarry::find($id);
        if( $data ){
            return $this->view('forone::' . $this->uri. "/show", compact('data'));
        }else{
            return $this->redirectWithError('未找到数据');
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
        //
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
        $carry = UserCarry::find($id);
        if( ! $carry ){
            return redirect()->route('admin.'.$this->uri.'.show',['id'=>$id])->withErrors(['default'=>"操作失败!未找到数据"]);
        }
        
        if( $carry->status != UserCarry::STATUS_PENDING ){
            return redirect()->route('admin.'.$this->uri.'.show',['id'=>$id])->withErrors(['default'=>'该申请不能操作,因为该申请状态已经变更']);
        }

        $carry->status = $request->get('status');
        $carry->passed_date = date('Y-m-d');
        $carry->passed_uid = auth()->user()->getKey();
        $carry->msg = $request->get('msg');
        $carry->save();

        // 操作记录
        // To-Do
        
        return redirect()->route('admin.'.$this->uri.'.show',['id'=>$id])->withErrors(['default'=>'操作成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function passed(Request $request){
        $results = [
            'columns' => [
                ['客户', 'Model1',function($model){
                    return $model->user->formatInfo();
                }],
                ['金额','money'],
                ['银行','Model2',function($model){
                    return $model->bank->name .' - ' . $model->bankzone;
                }],
                ['卡号','bank_card'],
                ['申请时间','created_at',function($created_at){
                    return $created_at->format('Y-m-d');
                }],
                ['状态','Model3',function($model){
                switch($model->status){
                    case UserCarry::STATUS_NOT_PASSED :
                        $style = 'label-danger';
                        break;
                    case UserCarry::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case UserCarry::STATUS_PENDING :
                        $style = 'label-info';
                        break;
                    case UserCarry::STATUS_CANCEL :
                        $style = 'label-default';
                        break;
                }
                return '<a href="'.route('admin.'.$this->uri.'.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.UserCarry::getStatusTitle($model->status).'</span></a>';
                    return ;
                }]
            ]
        ];
        $paginate = UserCarry::with(['user','bank'])->where('status',UserCarry::STATUS_PASSED)->orderBy('id','desc');
        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('bank_card', 'LIKE', '%'.$value.'%');
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

    public function unpassed(Request $request){
        $results = [
            'columns' => [
                ['客户', 'Model1',function($model){
                    return $model->user->formatInfo();
                }],
                ['金额','money'],
                ['银行','Model2',function($model){
                    return $model->bank->name .' - ' . $model->bankzone;
                }],
                ['卡号','bank_card'],
                ['申请时间','created_at',function($created_at){
                    return $created_at->format('Y-m-d');
                }],
                ['状态','Model3',function($model){
                switch($model->status){
                    case UserCarry::STATUS_NOT_PASSED :
                        $style = 'label-danger';
                        break;
                    case UserCarry::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case UserCarry::STATUS_PENDING :
                        $style = 'label-info';
                        break;
                    case UserCarry::STATUS_CANCEL :
                        $style = 'label-default';
                        break;
                }
                return '<a href="'.route('admin.'.$this->uri.'.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.UserCarry::getStatusTitle($model->status).'</span></a>';
                    return ;
                }]
            ]
        ];
        $paginate = UserCarry::with(['user','bank'])->where('status',UserCarry::STATUS_NOT_PASSED)->orderBy('id','desc');
        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('bank_card', 'LIKE', '%'.$value.'%');
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

    public function cancel(Request $request){
        $results = [
            'columns' => [
                ['客户', 'Model1',function($model){
                    return $model->user->formatInfo();
                }],
                ['金额','money'],
                ['银行','Model2',function($model){
                    return $model->bank->name .' - ' . $model->bankzone;
                }],
                ['卡号','bank_card'],
                ['申请时间','created_at',function($created_at){
                    return $created_at->format('Y-m-d');
                }],
                ['状态','Model3',function($model){
                switch($model->status){
                    case UserCarry::STATUS_NOT_PASSED :
                        $style = 'label-danger';
                        break;
                    case UserCarry::STATUS_PASSED :
                        $style = 'label-success';
                        break;
                    case UserCarry::STATUS_PENDING :
                        $style = 'label-info';
                        break;
                    case UserCarry::STATUS_CANCEL :
                        $style = 'label-default';
                        break;
                }
                return '<a href="'.route('admin.'.$this->uri.'.show',['id'=>$model->getKey()]).'"><span class="label '.$style.'">'.UserCarry::getStatusTitle($model->status).'</span></a>';
                    return ;
                }]
            ]
        ];
        $paginate = UserCarry::with(['user','bank'])->where('status',UserCarry::STATUS_CANCEL)->orderBy('id','desc');
        $all = $request->except(['page']);
        if (!sizeof($all)) {
            $paginate = $paginate->paginate(15);
        }else{
            //遍历筛选条件
            foreach ($all as $key => $value) {
                if ($key == 'keywords') { //检索的关键词，定义检索关键词的检索语句
                    $paginate->where('bank_card', 'LIKE', '%'.$value.'%');
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
}
