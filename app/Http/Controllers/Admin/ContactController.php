<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Contact;
use Form;

class ContactController extends BaseController
{
    function __construct()
    {
        parent::__construct('contacts', '咨询');
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
                ['编号', 'id'],
                ['称呼', 'Model1',function($model){
                    return '<a href="'.route('admin.'.$this->uri.'.show',['id'=>$model->getKey()]).'">'.$model->title.'</a>';
                }],
                ['电话','phone'],
                ['类型','type',function($type){
                    return $type == 1 ? '投资理财' : '借贷';
                }],
                ['已联系','Model2',function($model){
                    if( $model->status ){
                        $btn_conf = ['name'=>'是','class'=>'btn-success','uri'=>$model->id,'method'=>'POST','id'=>$model->id];
                        $btn_data = ['status'=>false];
                    }else{
                        $btn_conf = ['name'=>'否','class'=>'btn-danger','uri'=>$model->id,'method'=>'POST','id'=>$model->id];
                        $btn_data = ['status'=>true];
                    }
                    return Form::form_button($btn_conf,$btn_data);
                }]
            ]
        ];
        $paginate = Contact::orderByRaw('id desc,status asc')->paginate(15);
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
        $data = Contact::find($id);
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
        $data = Contact::find($id);
        if( $data ){
            $data->status = $request->get('status');
            $data->save();
            return $this->toIndex();
        }else{
            return $this->redirectWithError('数据未找到');
        }
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
