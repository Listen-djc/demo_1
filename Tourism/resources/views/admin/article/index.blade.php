@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>文章列表</h3>
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
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th class="tc">标题</th>
                        <th class="tc">点击</th>
                        <th class="tc">作者</th>
                        <th class="tc">发布时间</th>
                        <th class="tc">所属景区</th>
                        <th class="tc" width="8%">状态</th>
                        <th class="tc" width="8%">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->art_id}}</td>
                        <td class="tc" style="text-align:center;">
                            <a href="{{url('admin/article/'.$v->art_id)}}" style="width: 100%">{{$v->art_title}}</a>
                        </td>
                        <td class="tc">{{$v->art_view}}</td>
                        <td class="tc">{{$v->art_editor}}</td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->art_time)}}</td>
                        <td class="tc">{{$v->sc_name}}</td>
                        <td class="tc"  style="text-align:center;">
                            @if($v->art_status==1)
                                <a href="javascript:;" onclick="onStatus('{{$v->art_id}}',0)" style="width: 100%">显示</a>
                            @else
                                <a href="javascript:;" onclick="onStatus('{{$v->art_id}}',1)" style="width: 100%">关闭</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delAre('{{$v->art_id}}')">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

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

        function onStatus(art_id,art_status) {
            //询问框
            var stt = '';
            if(art_status==1){
                stt='显示';
            }else{
                stt='关闭';
            }
            layer.confirm('你确定要'+stt+'这个文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/article/onstatus')}}",{'_token':'{{csrf_token()}}','art_id':art_id,'art_status':art_status,'stt':stt},function (data) {
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

        function delAre(art_id) {
            //询问框
            layer.confirm('你确定要删除这个文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/article')}}/"+art_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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