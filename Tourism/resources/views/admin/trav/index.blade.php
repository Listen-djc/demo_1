@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;游客评论管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>游客评论列表</h3>
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
                        <th class="tc">用户</th>
                        <th class="tc">评论内容</th>
                        <th class="tc" width="100px">缩略图</th>
                        <th class="tc">撰写时间</th>
                        <th class="tc">所属景区</th>
                        <th class="tc">回复次数</th>
                        <th class="tc" width="8%">状态</th>
                        <th class="tc" width="8%">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc tr_id">{{$v->tr_id}}</td>
                        <td class="tc">{{$v->us_name}}</td>
                        <td class="tc">{!! $v->tr_content !!}</td>
                        <td class="tc">
                            @foreach($pic as $p)
                                @if($v->tr_id==$p->tr_id)
                                    <img class="imgto" width="45px" height="35px" style="border-radius: 5px;vertical-align:middle;" src="{{url($p->tp_picture)}}">
                                @endif
                            @endforeach
                        </td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->tr_time)}}</td>
                        <td class="tc">{{$v->sc_name}}</td>
                        <td class="tc" style="text-align:center;">
                            <?php $i = 0; ?>
                            @foreach($replay as $rp)
                                @if($rp->tr_id == $v->tr_id)
                                    <?php $i++; ?>
                                    @endif
                            @endforeach
                            <a href="{{url('admin/replay/'.$v->tr_id)}}" style="width: 100%">{{$i}}</a>
                        </td>
                        <td class="tc"  style="text-align:center;">
                            @if($v->tr_status==1)
                                <a href="javascript:;" onclick="onStatus('{{$v->tr_id}}',0)" style="width: 100%">显示</a>
                            @else
                                <a href="javascript:;" onclick="onStatus('{{$v->tr_id}}',1)" style="width: 100%">关闭</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/replay/create/'.'?tr_id='.$v->tr_id)}}">回复</a>
                            <a href="javascript:;" onclick="delAre('{{$v->tr_id}}')">删除</a>
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


        function onStatus(tr_id,tr_status) {
            //询问框
            var stt = '';
            if(tr_status==1){
                stt='显示';
            }else{
                stt='关闭';
            }
            layer.confirm('你确定要'+stt+'这个游客评论吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/trav/onstatus')}}",{'_token':'{{csrf_token()}}','tr_id':tr_id,'tr_status':tr_status,'stt':stt},function (data) {
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

        function delAre(tr_id) {
            //询问框
            layer.confirm('你确定要删除这个游客评论吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/trav')}}/"+tr_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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