@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;公告管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>公告列表</h3>
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
                    <a href="{{url('admin/notice/create')}}"><i class="fa fa-plus"></i>新增公告</a>
                    <a href="{{url('admin/notice')}}"><i class="fa fa-recycle"></i>全部公告</a>
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
                        <th class="tc">内容</th>
                        <th class="tc">发布时间</th>
                        <th class="tc">所属景区</th>
                        <th class="tc" width="8%">状态</th>
                        <th class="tc" width="8%">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->nt_id}}</td>
                        <td class="tc">{{$v->nt_title}}</td>
                        <td class="tc">{!! $v->nt_content !!}</td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->nt_time)}}</td>
                        <td class="tc">{{$v->sc_name}}</td>
                        <td class="tc"  style="text-align:center;">
                            @if($v->nt_status==1)
                                <a href="javascript:;" onclick="onStatus('{{$v->nt_id}}',0)" style="width: 100%">显示</a>
                            @else
                                <a href="javascript:;" onclick="onStatus('{{$v->nt_id}}',1)" style="width: 100%">关闭</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/notice/'.$v->nt_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delAre('{{$v->nt_id}}')">删除</a>
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

        function onStatus(nt_id,nt_status) {
            //询问框
            var stt = '';
            if(nt_status==1){
                stt='显示';
            }else{
                stt='关闭';
            }
            layer.confirm('你确定要'+stt+'这个公告吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/notice/onstatus')}}",{'_token':'{{csrf_token()}}','nt_id':nt_id,'nt_status':nt_status,'stt':stt},function (data) {
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

        function delAre(nt_id) {
            //询问框
            layer.confirm('你确定要删除这个分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/notice')}}/"+nt_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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