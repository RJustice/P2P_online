<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\DealExp;
use App\Article;
use App\Section;
use App\Category;
use App\Deal;
use Form;

class DealExpController extends BaseController {

    function __construct()
    {
        parent::__construct('dealexp', '理财项目说明');
    }

    public function index()
    {
        $results = [
            'columns' => [
                ['编号', 'id'],
                ['标题', 'title'],
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
        $paginate = DealExp::where('type',Article::TYPE_DEALEXP)->where('deleted',false)->orderBy('id','desc')->paginate(15);
        $results['items'] = $paginate;

        return $this->view('forone::' . $this->uri.'.index', compact('results'));
    }

    /**
     *
     * @return View
     */
    public function create()
    {
        $data = new DealExp();
        return $this->view('forone::'.$this->uri.'.create',compact('data'));
    }

    /**
     *
     * @param CreateRoleRequest $request
     * @return View
     */
    public function store(Request $request)
    {
        $dealExp = DealExp::create($request->except('_method','id', '_token','_url'));
        $deal = Deal::find($request->get('deal_id'));
        $deal->exp_link = url('dealexp/show',['id'=>$dealExp->getKey()]);
        $deal->save();
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
        $data = DealExp::find($id);
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
        $dealExp = DealExp::find($id);
        $dealExp->update($data);

        $deal = Deal::find($request->get('deal_id'));
        $deal->exp_link = url('dealexp',['id'=>$dealExp->getKey()]);
        $deal->title = '8888';
        $deal->save();

        return $this->toIndex();
    }

}