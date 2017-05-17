@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;评论回复管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>评论回复列表</h3>
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/trav')}}"><i class="fa fa-recycle"></i>全部游客评论</a>
                    <a href="{{url('admin/replay')}}"><i class="fa fa-recycle"></i>全部评论回复</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th class="tc">管理员</th>
                        <th class="tc">回复内容</th>
                        <th class="tc">回复时间</th>
                        <th class="tc">游客评论ID</th>
                        <th class="tc" width="8%">操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc re_id">{{$v->re_id}}</td>
                            <td class="tc">{{$v->ad_name}}</td>
                            <td class="tc">{!! $v->re_content !!}</td>
                            <td class="tc">{{date('Y-m-d H:i:s',$v->re_time)}}</td>
                            <td class="tc" style="text-align:center;">
                                <a href="{{url('admin/trav/'.$v->tr_id)}}" style="width: 100%">{{$v->tr_id}}</a>
                            </td>
                            <td>
                                <a href="{{url('admin/replay/'.$v->re_id.'/edit')}}">编辑</a>
                                <a href="javascript:;" onclick="delAre('{{$v->re_id}}')">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                {{--显示放大的图片--}}
                <img id="goods_minimg" src=""/>
                <style type="text/css">
                    #goods_minimg{
                        width:230px;
                        height:200px;
                        display:none;
                        position:fixed;
                        top:10px;
                        right:10px;
                        border:1px solid #ccc;
                        border-radius:5px;
                    }
                </style>

                {{--  分页页面显示 --}}
                <div class="page_list">
                    <ul>
                    </ul>
                </div>

                <style type="text/css">
                    .result_content ul li span {
                        font-sizr:15px;
                        padding: 6px 12px;
                    }
                </style>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script type="text/javascript">

        $('.imgto').mousemove(function () {
            if($(this).attr("src") != "upload/admin"){
                $("#goods_minimg").css("display","block");
                $("#goods_minimg").attr("src",$(this).attr("src"));
            }else{

            }
        });

        $('.imgto').mouseout(function () {
            $("#goods_minimg").css("display","none");
        });


        function onStatus(re_id,re_status) {
            //询问框
            var stt = '';
            if(re_status==1){
                stt='显示';
            }else{
                stt='关闭';
            }
            layer.confirm('你确定要'+stt+'这个评论回复吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/trav/onstatus')}}",{'_token':'{{csrf_token()}}','re_id':re_id,'re_status':re_status,'stt':stt},function (data) {
                    location.href=location.href;//刷新当前页面
                    if(data.status==0){
                        layer.alert(data.msg, {icon: 6});
                    }else{
                        layer.alert(data.msg, {icon: 5});
                    }
                });
            }, function(){
            });
        }

        function delAre(re_id) {
            //询问框
            layer.confirm('你确定要删除这个评论回复吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/replay')}}/"+re_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                    location.href=location.href;//刷新当前页面
                    if(data.status==0){
                        layer.alert(data.msg, {icon: 6});
                    }else{
                        layer.alert(data.msg, {icon: 5});
                    }
                });
            }, function(){
            });
        }
    </script>
@endsection