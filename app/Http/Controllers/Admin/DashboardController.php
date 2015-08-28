<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use App\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Article;
use App\Category;
use App\Section;
use App\Page;

class DashboardController extends BaseController {

    function __construct()
    {
        parent::__construct('dashboard', '面板');
    }

    public function index()
    {
        // $results = [
        //     'columns' => [
        //         ['编号', 'id'],
        //         ['分类名称', 'name'],
        //         ['分类说明', 'description'],
        //         ['创建时间', 'created_at'],
        //         ['更新时间', 'updated_at'],
        //         ['操作', 'buttons', function ($data) {
        //             $buttons = [
        //                 ['编辑'],
        //                 [['name'=>'文章列表','class'=>'btn-danger','uri' => 'alists','params'=>'id','method'=>'GET'],[]]
        //             ];
        //             return $buttons;
        //         }]
        //     ]
        // ];
        // $paginate = Category::orderBy('id','desc')->paginate(15);
        // $results['items'] = $paginate;
        
        // return $this->view('forone::' . $this->uri.'.index', compact('results'));
        return view('admin.dashboard.index');
    }
}