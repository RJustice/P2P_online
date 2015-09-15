<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserMeta;
use Form;

class EmployeeController extends Controller
{

    function __construct()
    {
        parent::__construct('employee', '员工');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $results = [
            'columns' => [
                ['ID', 'id'],
                ['姓名', 'name'],
                ['手机号','phone'],
                ['电子邮箱', 'email'],
                ['注册时间', 'created_at'],
                // ['推荐人','metas',function($metas){
                //     return $metas->where('meta_key','rec_user')->first()->meta_value;
                // }],
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
                        [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['deleted'=>1]]
                    ];
                    return $buttons;
                }],
            ]
        ];
        $paginate = User::where('type',User::TYPE_EMPLOYEE)->orderBy('id','desc')->paginate(15);
        $results['items'] = $paginate;

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
        $data = $request->only(['phone','name','email','password','is_delete','idno','province_id','city_id','address']);
        $data['type'] = User::TYPE_EMPLOYEE;
        $data['idcardpassed'] = 1;
        $data['idcardpassed_time'] = time();
        $data['state'] = User::STATE_SYS_CREATED;
        $data['phonepassed'] = 1;
        $data['referer'] = User::REFERER_SYSTEM;
        User::create();
        return redirect()->route('admin.employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        if ($data) {
            return $this->view('forone::' . $this->uri. "/show", compact('data'));
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
        $name = $request->get('name');
        $email = $request->get('email');
        $count = User::whereName($name)->where('id', '!=', $id)->count();
        if ($count > 0) {
            return $this->redirectWithError('名称不能重复');
        }
        $count = User::whereEmail($email)->where('id', '!=', $id)->count();
        if ($count > 0) {
            return $this->redirectWithError('邮箱不能重复');
        }
        User::findOrFail($id)->update($request->only(['name', 'email']));
        return redirect()->route('admin.admins.index');
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
