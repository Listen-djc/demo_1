@extends('layouts.admin')
@section('content')
    <link href="{{asset('admin/style/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/style/css/new.css')}}" rel="stylesheet">
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;文章管理
    </div>
    <!--面包屑导航 结束-->
    <article class="blogs">
        <div class="index_about">
            <h2 class="c_titile">{{$data->art_title}}</h2>
            <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$data->art_time)}}</span><span>编辑：{{$data->art_editor}}</span><span>查看次数：{{$data->art_view}}</span></p>
            <ul class="infos">
                {!! $data->art_content !!}
            </ul>
            <div class="keybq">
                <p><span>关键字词</span>：{{$data->art_description}}</p>

            </div>
            <div class="ad"> </div>
        </div>
    </article>
@endsection