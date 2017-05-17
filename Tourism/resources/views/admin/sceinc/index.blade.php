@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部景区表
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>自定义导航管理</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $v)
                            <p>{{$v}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/sceinc/create')}}"><i class="fa fa-plus"></i>添加景区</a>
                <a href="{{url('admin/sceinc/')}}"><i class="fa fa-recycle"></i>全部景区</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">ID</th>
                    <th class="tc" width="10%" >景区</th>
                    <th class="tc">图片</th>
                    <th class="tc">关键词</th>
                    <th class="tc">景区介绍</th>
                    <th class="tc">原价</th>
                    <th class="tc">优惠价</th>
                    <th class="tc">添加时间</th>
                    <th class="tc">更新时间</th>
                    <th class="tc">热门度</th>
                    <th class="tc">景区管理员</th>
                    <th class="tc" width="4%">状态</th>
                    <th class="tc" width="8%">操作</th>
                </tr>
                @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->sc_id}}</td>
                        <td class="tc" >{{$v->sc_name}}</td>
                        <td class="tc"><img class="imgto" width="45px" height="35px" style="border-radius: 5px;vertical-align:middle;" src="{{url($v->sp_picture)}}"></td>
                        <td class="tc" >{{$v->sc_keyword}}</td>
                        <td class="tc" >{{$v->sc_introduce}}</td>
                        <td class="tc">￥{{$v->sc_price}}</td>
                        <td class="tc">￥{{$v->sc_pre_price}}</td>
                        <td class="tc">{{date('Y-m-d',$v->sc_cre_time)}}</td>
                        <td class="tc">{{date('Y-m-d',$v->sc_time)}}</td>
                        <td class="tc">{{$v->sc_view}}</td>
                        <td class="tc">{{$v->ad_name}}</td>
                        <td class="tc"  style="text-align:center;">
                            @if($v->sc_status==1)
                                <a href="javascript:;" onclick="onStatus('{{$v->sc_id}}',0)" style="width: 100%">正常</a>
                            @else
                                <a href="javascript:;" onclick="onStatus('{{$v->sc_id}}',1)" style="width: 100%">停用</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/sceinc/'.$v->sc_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delCate('{{$v->sc_id}}')">删除</a>
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
                    {{$data->links()}}
                </ul>
            </div>

            <div class="page_conf">

            </div>
        </div>
    </div>
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


        function onStatus(sc_id,sc_status) {
            //询问框
            var stt = '';
            if(sc_status==1){
                stt='开启';
            }else{
                stt='关闭';
            }
            layer.confirm('你确定要'+stt+'这个景区吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/sceinc/onstatus')}}",{'_token':'{{csrf_token()}}','sc_id':sc_id,'sc_status':sc_status,'stt':stt},function (data) {
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

        function delCate(sc_id) {
            //询问框
            layer.confirm('你确定要删除这个景区吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/sceinc')}}/"+sc_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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