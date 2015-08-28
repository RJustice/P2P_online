<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Section;

class CategoryController extends BaseController {

    function __construct()
    {
        parent::__construct('category', '分类');
    }

    public function index()
    {
        $results = [
            'columns' => [
                ['编号', 'id'],
                ['分类名称', 'name'],
                ['分类说明', 'description'],
                ['创建时间', 'created_at'],
                ['更新时间', 'updated_at'],
                ['操作', 'buttons', function ($data) {
                    $buttons = [
                        ['编辑'],
                        [['name'=>'文章列表','class'=>'btn-danger','uri' => 'alists','params'=>'id','method'=>'GET'],[]]
                    ];
                    return $buttons;
                }]
            ]
        ];
        $paginate = Category::orderBy('id','desc')->paginate(15);
        $results['items'] = $paginate;

        return $this->view('forone::' . $this->uri.'.index', compact('results'));
    }

    /**
     *
     * @return View
     */
    public function create()
    {
        return $this->view('forone::'.$this->uri.'.create');
    }

    /**
     *
     * @param CreateRoleRequest $request
     * @return View
     */
    public function store(Request $request)
    {
        Category::create($request->except('id', '_token'));
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
        $data = Category::find($id);
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
        $data = $request->except('id', '_token');
        Category::findOrFail($id)->update($data);

        return $this->toIndex();
    }


    public function alists(Request $request){
        $id = $request->get('id');
        $cat = Category::findOrFail($id);
        // $articles = $cat->articles;
        $results = [
            'columns' => [
                ['编号', 'id'],
                ['文章名称', 'title'],                
                ['创建时间', 'created_at'],
                ['更新时间', 'updated_at'],
                ['操作', 'buttons', function ($data) {
                    $buttons = [
                        ['编辑'],
                        ['删除'],
                    ];
                    return $buttons;
                }]
            ]
        ];
        $paginate = $cat->articles()->paginate(15);
        $results['items'] = $paginate;

        return $this->view('forone::' . $this->uri.'.alists', compact('results','cat'));
    }
}