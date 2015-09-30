@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">系统消息</a>
    </div>
</div>
<div class="tab-box clearfix pub-tab message-box">
    <div class="search-data">
        <div class="text-describe percent-wid"> 
            仅显示近3个月消息记录，共1条消息，其中0条未读
        </div>
    </div>
    <div class="table-box clearfix">
        <table cellspacing="0" cellpadding="0" id="listTable">
            <colgroup>
                <col width="15%">
                <col width="15%">
                <col width="50%">
                <col width="20%">
            </colgroup>
            <thead>
            <tr>
                <th></th>
                <th>发件人</th>
                <th>主题</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <tr id="msg-1600538454">
                    <td class="tl"><input type="checkbox" value="1600538454" autocomplete="off" id="msg_1600538454"><img src="/images/mailer2.png"></td>
                    <td>农发众诚</td>
                    <td class="look" data="1600538454">您刚刚修改了提现的银行帐户</td>
                    <td>2015-09-28</td>
                </tr>                        <tr>
                <td colspan="4" class="tl"><input type="checkbox" id="choose" onclick="choose_all()">全选<a href="javascript:;" class="del" id="deletebtn1" onclick="delmsg();">删除</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
@stop