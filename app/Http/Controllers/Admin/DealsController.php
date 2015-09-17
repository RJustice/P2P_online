<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Form;
use App\Deal;
use App\User;

class DealsController extends Controller
{

    function __construct(){
        parent::__construct('deals','理财项目');
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
                ['理财项目', 'title'],
                ['收益率','rate'],
                ['起投资金','min_loan_money'],
                ['还款方式','loan_type',function($loan_type){
                    return Deal::getLoanTypeTitle($loan_type);
                }],
                ['可用','is_effect',function($is_effect){
                    // if( $sModel['published'] ){
                    //     $btn_conf = ['name'=>'是','class'=>'btn-success','uri'=>$sModel['id'],'method'=>'POST','id'=>$sModel['id']];
                    //     $btn_data = ['published'=>0];
                    // }else{
                    //     $btn_conf = ['name'=>'否','class'=>'btn-danger','uri'=>$sModel['id'],'method'=>'POST','id'=>$sModel['id']];
                    //     $btn_data = ['published'=>1];
                    // }
                    // return Form::form_button($btn_conf,$btn_data);
                    return $is_effect;
                }],
                ['操作','other',function(){
                    return '<div class="dropdown">
                              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                操作
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Something else here</a></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                            </div>';
                }],
                // ['操作', 'buttons', function ($data) {
                //     $buttons = [
                //         ['编辑'],
                //         [['name'=>'删除','class'=>'btn-danger','uri'=>$data['id'],'method'=>'POST'],['deleted'=>1]]
                //     ];
                //     return $buttons;
                // }],
            ]
        ];
        $paginate = Deal::where('is_effect',1)->where('is_deleted',0)->orderByRaw('sort desc,id desc')->paginate(15);
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
        $data = new Deal();
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
        $data = $request->only(['titlecolor','deal_sn','title','sub_title','repay_time','rate','loan_type','min_loan_money','max_loan_money','is_effect','is_hot','is_best','is_rec','borrow_amount','load_money','buy_count','intro_info','description']);
        $data['daliy_returns'] = 10000 * ( $data['rate'] / 100 ) / 365 ;
        $deal = Deal::create($data);
        if( $deal ){
            // To-do Add Admin Control Log
            return redirect()->route('admin.'.$this->uri.'.index');
        }else{
            return 'error';
        }
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
        return ;
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
