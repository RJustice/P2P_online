<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Company;
use Form;

class CompanyController extends BaseController {

    function __construct()
    {
        parent::__construct('company', '文章');
    }

    public function index()
    {
        $results = [
            'columns' => [
                ['编号', 'id'],
                ['公司名', 'name'],
                // ['分类','categoryid',function($categoryid){
                //     return Category::find($categoryid)->name;
                // }],
                ['区域','Model',function($model){
                    return $model->formatRegion();
                }],
                ['操作', 'buttons', function ($data) {
                    $buttons = [
                        ['编辑'],
                        [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['status'=>0]]
                    ];
                    return $buttons;
                }],
            ]
        ];
        $paginate = Company::where('status',Company::STATUS_VAILD)->orderBy('id','desc')->paginate(15);
        $results['items'] = $paginate;

        return $this->view('forone::' . $this->uri.'.index', compact('results'));
    }

    /**
     *
     * @return View
     */
    public function create()
    {
        $data = new Company();
        return $this->view('forone::'.$this->uri.'.create',compact('data'));
    }

    /**
     *
     * @param CreateRoleRequest $request
     * @return View
     */
    public function store(Request $request)
    {
        Company::create($request->except('_method','id', '_token','_url'));
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
        $data = Company::find($id);
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
        Company::findOrFail($id)->update($data);

        return $this->toIndex();
    }

}