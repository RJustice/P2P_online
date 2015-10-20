@extends('_layouts.center')
@section('css')
@stop

@section('content')
<div class="list-title clearfix">
    {{-- <div class="">
        <a href="{{ route('member.fund.summarydetail') }}">资金明细</a>
    </div> --}}
    <div class="cur">
        <a href="{{ route('member.fund.logs') }}">资金明细</a>
    </div>
</div>
<div class="tab-box clearfix pub-tab">    
     {{-- <div class="search-data">
        <div class="text-describe">
              操作类型
      <select name="log_type" id="log_type" class="select-style">
        <option value="">请选择</option>
        <option value="2">会员升级</option><option value="3">会员充值</option><option value="4">提现冻结</option><option value="5">撤消提现</option><option value="6">会员投标</option><option value="7">管理员操作</option><option value="8">流标返还</option><option value="9">会员还款</option><option value="10">网站代还</option><option value="11">偿还借款</option><option value="12">提现失败</option><option value="13">推广奖励</option><option value="14">升级VIP</option><option value="15">投标成功本金解冻</option><option value="16">复审未通过返还</option><option value="17">借款入帐</option><option value="18">借款管理费</option><option value="19">借款保证金</option><option value="20">投标奖励</option><option value="21">支付投标奖励</option><option value="22">视频认证费用</option><option value="23">利息管理费</option><option value="24">还款完成解冻</option><option value="25">实名认证费用</option><option value="26">现场认证费用</option><option value="27">充值审核</option><option value="28">投标成功待收利息</option><option value="29">提现成功</option><option value="30">逾期罚息</option><option value="31">催收费</option><option value="32">线下充值奖励</option><option value="33">续投奖励(预奖励)</option><option value="34">续投奖励</option><option value="35">续投奖励(取消)</option><option value="36">提现通过，审核处理中</option><option value="37">企业直投投标</option><option value="38">企业直投待收利息</option><option value="39">企业直投待收金额</option><option value="40">企业直投回款续投奖励</option><option value="41">企业直投投标奖励</option><option value="42">支付企业直投投标奖励</option><option value="43">可用余额利息</option><option value="44">企业直投回购</option><option value="45">网站抽奖奖励</option><option value="46">购买债权</option><option value="47">资金赎回</option><option value="48">转让债权手续费</option><option value="49">注册红包奖励</option><option value="62">平台补息</option><option value="61">pos刷卡充值</option><option value="63">划扣充值</option><option value="64">红包折现</option><option value="65">红包充值</option><option value="66">红包投资失败减去红包充值</option><option value="67">历史标充值</option><option value="68">红包发放</option><option value="74">管理员增加余额</option><option value="75">管理员减少余额</option><option value="76">管理员增加冻结金额</option><option value="77">管理员减少冻结金额</option><option value="90">提前还款</option><option value="91">提前还款(本金)</option><option value="92">提前还款(利息)</option><option value="101">发工资</option><option value="200">募集期间共计获得利息</option><option value="201">体验金收益</option><option value="202">体验金付息</option>                            </select>
        </div>
        <div class="div-search">起止日期<input class="Wdate" id="start-time" value="" type="text">-<input class="Wdate" id="end-time" value="" type="text">
        <span class="search-btn">搜&nbsp;&nbsp;索</span>
        <span class="search-btn"><a href="/User/fund/downloaddetail?" style="color: #fff">下&nbsp;&nbsp;载</a></span></div>
     </div> --}}
     <div class="table-box clearfix">
               <table cellpadding="0" cellspacing="0">
                    <colgroup>
                    <col width="16%">
                    <col width="20%">
                    <col width="17%">
                    <col width="17%">
                    <col width="17%">
                    <col width="15%">
                    </colgroup>
                    <thead>                                                                                
                        <tr>                                                                       
                            <th>交易类型</th>
                            <th>时间</th>
                            <th>交易金额（元）</th>
                            <th>账户余额（元）</th>
                            <th>账户资产（元）</th>
                            <th>说明</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if( $logs )
                        @foreach( $logs  as $log )
                        <tr>
                            <td>{{ App\UserMoneyLog::getLogTypeTitle($log->type) }}</td>
                            <td>{{ dd($log->created_at) }} {{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $log->money }}</td>
                            <td>{{ $log->can_money }}</td>
                            <td>{{ $log->account_money }}</td>
                            <td>{{ App\UserMoneyLog::getLogCtlTypeTitle($log->log_type) }}</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <p class="pager">
                    {{ $logs ? $logs->render() :"" }}
                </p>
  </div>

</div>
@stop

@section('js')
@stop