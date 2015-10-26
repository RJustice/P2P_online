<div id="uc-cate">
    <div class="hdc {{ str_is('member',Route::current()->getName()) ? 'c-hds':'c-hd' }} c-hd0" data-href="{{ route('member') }}">我的账户</div>
    <div class="hdc {{ in_array(Route::current()->getName(),['member.fund.recharge','member.fund.carry','member.fund.summarydetail','member.fund.logs','member.fund.carrylogs']) ? 'c-hds':'c-hd' }} c-hd1">资金管理</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li class="{{ str_is('member.fund.carry',Route::current()->getName()) || str_is('member.fund.carrylogs',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.fund.carry') }}" class="uc-cate">提现</a></li>
            <li class="{{ str_is('member.fund.summarydetail',Route::current()->getName()) || str_is('member.fund.logs',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.fund.logs') }}" class="uc-cate">资金明细</a></li>
        </ul>
    </div>
    <div class="hdc {{ in_array(Route::current()->getName(),['member.account.basic','member.account.authenticate','member.account.bankcard','member.account.safe','member.account.resetpwd']) ? 'c-hds':'c-hd' }} c-hd2">账户管理</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li class="{{ str_is('member.account.basic',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.account.basic') }}" class="uc-cate">基本信息</a></li>
            <li class="{{ str_is('member.account.authenticate',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.account.authenticate') }}" class="uc-cate">认证信息</a></li>
            <li class="{{ str_is('member.account.bankcard',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.account.bankcard') }}" class="uc-cate">银行卡信息</a></li>
            <li class="{{ str_is('member.account.safe',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.account.safe') }}" class="uc-cate">安全信息</a></li>
            <li class="{{ str_is('member.account.resetpwd',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.account.resetpwd') }}" class="uc-cate">修改密码</a></li>
        </ul>
    </div>
    <div class="hdc {{ str_is('member.invest.index',Route::current()->getName()) ? 'c-hds':'c-hd' }} c-hd3" data-href="{{ route('member.invest.index') }}">投资管理</div>
    <div class="hdc {{ in_array(Route::current()->getName(),['member.fund.redeem','member.fund.redeemlogs','member.fund.redeem.{id?}']) ? 'c-hds':'c-hd' }} c-hd1">管理赎回</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li class="{{ str_is('member.fund.redeem',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.fund.redeem') }}" class="uc-cate">我要赎回</a></li>
            <li class="{{ str_is('member.fund.redeemlogs',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.fund.redeemlogs') }}" class="uc-cate">赎回记录</a></li>
        </ul>
    </div>
    {{-- <div class="hdc {{ str_is('member.message.index',Route::current()->getName()) ? 'c-hds':'c-hd' }} c-hd4">消息管理</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li class="{{ str_is('member.message.index',Route::current()->getName()) ? 'act' : '' }}"><a href="{{ route('member.message.index') }}" class="uc-cate">系统消息</a></li>
        </ul>
    </div>
    <div class="hdc {{ str_is('member.redpacket',Route::current()->getName()) ? 'c-hds':'c-hd' }} c-hd5" data-href="{{ route('member.redpacket') }}">红包管理</div> --}}
</div>