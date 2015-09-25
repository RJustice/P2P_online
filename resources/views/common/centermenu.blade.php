<div id="uc-cate">
    <div class="hdc c-hds c-hd0">我的账户</div>
    <div class="hdc c-hd c-hd1">资金管理</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li><a href="{{ route('member.fund.carry') }}" class="uc-cate">提现</a></li>
            <li><a href="{{ route('member.fund.summarydetail') }}" class="uc-cate">资金明细</a></li>
        </ul>
    </div>
    <div class="hdc c-hd c-hd2">账户管理</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li><a href="{{ route('member.account.basic') }}" class="uc-cate">基本信息</a></li>
            <li><a href="{{ route('member.account.authenticate') }}" class="uc-cate">认证信息</a></li>
            <li><a href="{{ route('member.account.bankcard') }}" class="uc-cate">银行卡信息</a></li>
            <li><a href="{{ route('member.account.safe') }}" class="uc-cate">安全信息</a></li>
        </ul>
    </div>
    <div class="hdc c-hd c-hd3" data-href="{{ route('member.invest.index') }}">投资管理</div>
    <div class="hdc c-hd c-hd4">消息管理</div>
    <div class="c-body">
        <ul class="uc-menu">
            <li><a href="{{ route('member.message.index') }}" class="uc-cate">系统消息</a></li>
        </ul>
    </div>
    <div class="hdc c-hd c-hd5" data-href="{{ route('member.redpacket.index') }}">红包管理</div>
</div>