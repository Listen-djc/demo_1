@extends('layouts.admin')
@section('content')
    <!--头部 开始-->
    <div class="top_box">
        <div class="top_left">
            <div class="logo">后台管理</div>
            <ul>
                <li><a href="{{url('/')}}" target="_blank" class="active">首页</a></li>
                <li><a href="{{url('admin/info')}}" target="main">管理页</a></li>
            </ul>
        </div>
        <div class="top_right">
            <ul>
                <li>管理员：{{session('user')['ad_name']}}</li>
                <li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
                <li><a href="{{url('admin/loginout')}}">退出</a></li>
            </ul>
        </div>
    </div>
    <!--头部 结束-->

    <!--左侧导航 开始-->
    <div class="menu_box">
        <ul>
            @if(session('user')['au_id']==1)
            <li>
                <h3><i class="fa fa-fw fa-bars"></i>用户管理</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/adminuser/')}}" target="main"><i class="fa fa-fw fa-graduation-cap"></i>管理员列表</a></li>
                    <li><a href="{{url('admin/adminuser/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加管理员</a></li>
                    <li><a href="{{url('admin/auth/')}}" target="main"><i class="fa fa-fw  fa-group"></i>权限分组列表</a></li>
                    <li><a href="{{url('admin/juri')}}" target="main"><i class="fa fa-fw  fa-key fa-unlock-alt"></i>分组权限列表</a></li>
                    <li><a href="{{url('admin/user/')}}" target="main"><i class="fa fa-fw  fa-child"></i>游客用户列表</a></li>
                </ul>
            </li>
            @endif
            <li>
                <h3><i class="fa fa-fw fa-bars"></i>景区管理</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/sceinc/')}}" target="main"><i class="fa fa-fw  fa-car"></i>景区列表</a></li>
                    <li><a href="{{url('admin/sceincmap')}}" target="main"><i class="fa fa-fw fa-flag"></i>景区路线列表</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-bars"></i>文章管理</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/notice')}}" target="main"><i class="fa fa-fw    fa-bullhorn"></i>景区公告</a></li>
                    <li><a href="{{url('admin/article')}}" target="main"><i class="fa fa-fw  fa-file-text"></i>景区文章</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-bars"></i>游记管理</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/trav/')}}" target="main"><i class="fa fa-fw  fa-envelope-o"></i>游记列表</a></li>
                    <li><a href="{{url('admin/replay/')}}" target="main"><i class="fa fa-fw  fa-edit"></i>游记回复列表</a></li>
                </ul>
            </li>
                @if(session('user')['au_id']==1)
                <li>
                    <h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
                    <ul class="sub_menu" style="display: block;">
                        <li><a href="{{url('admin/log/')}}" target="main"><i class="fa fa-fw  fa-steam"></i>日志管理</a></li>
                        <li><a href="{{url('admin/friendlinks/')}}" target="main"><i class="fa fa-fw  fa-link"></i>友情链接列表</a></li>
                        <li><a href="{{url('admin/navs/')}}" target="main"><i class="fa fa-fw fa-sliders"></i>自定义导航</a></li>
                        <li><a href="{{url('admin/config/')}}" target="main"><i class="fa fa-fw fa-cogs"></i>网站配置</a></li>
                    </ul>
                </li>
                @endif
            <li>
                <h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
                <ul class="sub_menu">
                    <li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
                    <li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>
                    <li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
                    <li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--左侧导航 结束-->

    <!--主体部分 开始-->
    <div class="main_box">
        <iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
    </div>
    <!--主体部分 结束-->

    <!--底部 开始-->
    <div class="bottom_box">
        CopyRight © 2015. Powered By <a href="http://www.houdunwang.com">http://www.houdunwang.com</a>.
    </div>
    <!--底部 结束-->
@endsection