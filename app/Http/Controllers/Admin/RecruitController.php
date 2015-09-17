<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Recruit;
use App\Article;
use App\Section;
use App\Category;
use Form;

class RecruitController extends BaseController {

    function __construct()
    {
        parent::__construct('recruit', '招聘');
    }

    public function index()
    {
        $results = [
            'columns' => [
                ['编号', 'id'],
                ['招聘职位', 'title'],
                // ['分类','categoryid',function($categoryid){
                //     return Category::find($categoryid)->name;
                // }],
                //['分类','category.name'],
                ['创建时间', 'created_at'],
                ['更新时间', 'updated_at'],
                ['发布状态','sModel',function($sModel){
                    if( $sModel['published'] ){
                        $btn_conf = ['name'=>'是','class'=>'btn-success','uri'=>$sModel['id'],'method'=>'POST','id'=>$sModel['id']];
                        $btn_data = ['published'=>false];
                    }else{
                        $btn_conf = ['name'=>'否','class'=>'btn-danger','uri'=>$sModel['id'],'method'=>'POST','id'=>$sModel['id']];
                        $btn_data = ['published'=>true];
                    }
                    return Form::form_button($btn_conf,$btn_data);
                }],
                ['操作', 'buttons', function ($data) {
                    $buttons = [
                        ['编辑'],
                        [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['deleted'=>1]]
                    ];
                    return $buttons;
                }],
            ]
        ];
        $paginate = Recruit::where('type',Article::TYPE_RECRUIT)->where('deleted',false)->orderBy('id','desc')->paginate(15);
        $results['items'] = $paginate;

        return $this->view('forone::' . $this->uri.'.index', compact('results'));
    }

    /**
     *
     * @return View
     */
    public function create()
    {
        $data = new Recruit();
        return $this->view('forone::'.$this->uri.'.create',compact('data'));
    }

    /**
     *
     * @param CreateRoleRequest $request
     * @return View
     */
    public function store(Request $request)
    {
        Recruit::create($request->except('_method','id', '_token','_url'));
        return $this->toIndex('保存成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Recruit::find($id);
        if ($data) {
            return view('forone::' . $this->uri."/edit", compact('data'));
        } else {
            return $this->redirectWithError('数据未找到');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->except('id', '_token','_method','_url');
        Recruit::findOrFail($id)->update($data);

        return $this->toIndex();
    }

}