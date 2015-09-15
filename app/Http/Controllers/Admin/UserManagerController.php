<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserMeta;
use Form;

class UserManagerController extends Controller
{

    function __construct()
    {
        parent::__construct('usermanager', '用户');
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
                ['注册时间', 'created_at'],
                ['推荐人','recUser',function($recUser){
                    if( $recUser ){
                        return $recUser->where('type',User::TYPE_EMPLOYEE)->first()->name;
                    }else{
                        return "暂无";
                    }
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
                ['操作', 'buttons', function ($data) {
                    $buttons = [
                        ['编辑'],
                        [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['deleted'=>1]],
                        [['name'=>'查看','class'=>'btn-info','uri'=>$data['id'],'method'=>'GET'],[]]
                    ];
                    return $buttons;
                }],
            ]
        ];
        $paginate = User::where('type',User::TYPE_MEMBER)
            ->orderBy('id','desc');

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
        //
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
        //
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
}
