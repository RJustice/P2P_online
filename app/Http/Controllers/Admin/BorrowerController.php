<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Borrower;
use Form;

class BorrowerController extends BaseController
{
    function __construct()
    {
        parent::__construct('borrowers', '债务人');
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
                ['姓名', 'name'],
                ['身份证号','idno'],
                ['用途','use'],
                ['借款','loan'],
                ['起始时间','Model',function($model){
                    return $model->repay_start.' ~ '.$model->repay_end;
                }],
                ['期数','periods'],
                ['操作', 'buttons', function ($data) {
                    $buttons = [
                        ['编辑'],
                        [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['is_deleted'=>1]]
                    ];
                    return $buttons;
                }],
            ]
        ];
        $paginate = Borrower::where('is_deleted',0)->orderBy('id','desc')->paginate(15);
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
        $data = new Borrower();
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
        // Company::create($request->except('_method','id', '_token','_url'));
        $borrower = new Borrower;
        $borrower->name = $request->get('name');
        $borrower->idno = $request->get('idno');
        $borrower->use = $request->get('use');
        $borrower->loan = $request->get('loan');
        $borrower->repay_start = $request->get('repay_start');
        $borrower->repay_end = $request->get('repay_end');
        $borrower->periods = $request->get('periods');
        $borrower->save();
        return $this->toIndex('保存成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Borrower::find($id);
        if ($data) {
            return view('forone::' . $this->uri."/edit", compact('data'));
        } else {
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
        $borrower = Borrower::find($id);
        if( $borrower ){
            // $data = $request->only('name','idno','use','loan','repay_start','repay_end','periods','is_deleted');
            $data = $request->except('id', '_token','_method','_url');
            $borrower->update($data);
        }else{
            return $this->redirectWithError('数据未找到');
        }
        return $this->toIndex();
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
