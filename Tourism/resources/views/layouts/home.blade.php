<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{asset('home/style/images/favicon.ico')}}">
    <link rel="shortcut icon" href="{{asset('home/style/images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('home/style/css/style.css')}}">
    <script src="{{asset('home/style/js/jquery.js')}}"></script>
    <script src="{{asset('home/style/js/jquery-migrate-1.1.1.js')}}"></script>
    <script src="{{asset('home/style/js/superfish.js')}}"></script>
    <script src="{{asset('home/style/js/jquery.equalheights.js')}}"></script>
    <script src="{{asset('home/style/js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('home/style/js/jquery.ui.totop.js')}}"></script>
    @yield('info')
        <!--[if lt IE 8]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
            <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
    </div>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="{{asset('home/style/js/html5shiv.js')}}"></script>
    <link rel="stylesheet" media="screen" href="{{asset('home/style/css/ie.css')}}">

    <![endif]-->
    <style type="text/css">
        div span  a:hover{
            color:lightblue;
        }
    </style>
</head>
<body>
<header>

    <div style="background: white;width: 100%;height:25px;padding-left: 40px;font-size: 15px;line-height: 25px;">
        <span>您好，欢迎访问南阳市旅游网！　　我的旅游</span>
        <span style="float: right;margin-right: 200px;">
            @if(empty(session('home_user')))
                游客&nbsp;&nbsp;
                <a href="{{url('/login')}}">登录</a>
                <a href="{{url('/register')}}" target="_blank">立即注册</a>
            @else
                <a href="{{url('/user')}}" style="color: #0000cc">{{session('home_user')['us_name']}}</a>&nbsp;&nbsp;
                <a href="{{url('/pass')}}">修改密码</a>
                <a href="{{url('/loginout')}}">退出登录</a>
            @endif
        </span>
    </div>

    <div class="container_12">
        <div class="grid_12">
            <h1><a href="#" style="width: 166px; height: 166px; background:url({{asset('home/style/images/logo.jpg')}}) center ; border-radius: 83px;">{{--<img src="{{asset('home/style/images/logo.jpg')}}" alt="China NanYang">--}}</a> </h1>


            <div class="clear"></div>
        </div>
        <div class="menu_block">
            <nav	class="" >
                <ul class="sf-menu">
                    @foreach($navs as $k =>$v)
                        <li><a href="{{url($v->nav_url)}}" style="font-size: 28px;">{{$v->nav_name}}</a></li>
                    @endforeach
                </ul>
            </nav>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</header>
@yield('content')

<footer>
    <div class="container_12">
        <div class="grid_12">
            <div class="socials">
                @foreach($friend_links as $f)
                    <a href="{{$f->link_url}}" title="{{$f->link_title}}">{{$f->name}}</a>
                @endforeach
            </div>
            <div class="copy">
                @<a target="_blank" href="http://www.nyist.net/">南阳理工学院</a>
            </div></div>
        <div class="clear"></div>
    </div>

</footer>

</body>
</html>