<div id="header-container" class="header-container">
    <div class="constr">
        <div class="wrap clearfix">
            <div class="f-l">
                <span>客服电话: 400-123 456 78</span>
                <div class="sharemk">
                    <a href="" class="share weibo"></a>
                    <a href="" class="share weixin"></a>
                </div>
            </div>
            <div class="f-r">
                <div id="user-head-tip" class="pr">
                    @include('demo.common.userstate')
                </div>
            </div>
        </div>
        <div class="main-bars">
            <div class="main-bar wrap">
                <div class="logo">
                    <a href="{{ url('/demo') }}" class="link f-l">
                        <img width="263" height="58" src="http://p2p.example.com/public/attachment/201011/4cdd501dc023b.png">
                    </a>
                </div>
                <ul class="main-nav">
                    <li rel="1" class="n-1 mr5 current">
                        <a href="{{ url('/demo') }}">首页</a>
                    </li>
                    <li rel="2" class="n-2 mr5">
                        <a href="{{ url('/projects') }}">我要理财</a>
                    </li>
                    <li rel="3" class="n-3 mr5">
                        <a href="{{ url('/usercenter') }}">个人中心</a>
                    </li>
                    <li rel="4" class="n-4 mr5">
                        <a href="{{ url('/newlywed') }}">新手指引</a>
                    </li>
                    <li rel="5" class="n-5 mr5">
                        <a href="{{ url('/about') }}">关于我们</a>
                    </li>
                    <li rel="6" class="n-6 mr5"></li>
                </ul>
            </div>
        </div>
    </div>
</div>