@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部日志表
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
                <a href="javascript:;" onclick="delAll()"><i class="fa fa-plus"></i>清空日志</a>
                <a href="{{url('admin/log/')}}"><i class="fa fa-recycle"></i>全部日志</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">ID</th>
                    <th class="tc" width="10%" >操作人</th>
                    <th class="tc" width="50%">操作记录</th>
                    <th class="tc">IP</th>
                    <th class="tc">时间</th>
                    <th class="tc" width="5%">操作</th>
                </tr>
                @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->lg_id}}</td>
                        <td class="tc" >{{$v->ad_name}}</td>
                        <td class="tc" >{{$v->lg_content}}</td>
                        <td class="tc">{{$v->lg_ip}}</td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->lg_time)}}</td>
                        <td style="text-align:center;">
                            <a href="javascript:;" style="width: 100%" onclick="delCate('{{$v->lg_id}}')">删除</a>
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

            <div class="page_conf">

            </div>
        </div>
    </div>
    <!--搜索结果页面 列表 结束-->

    <script type="text/javascript">

        function delAll() {
            //询问框
            layer.confirm('你确定要清理全部日志吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/log/destroyAll')}}",{'_token':'{{csrf_token()}}'},function (data) {
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

        function delCate(lg_id) {
            //询问框
            layer.confirm('你确定要删除这个日志吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/log')}}/"+lg_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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