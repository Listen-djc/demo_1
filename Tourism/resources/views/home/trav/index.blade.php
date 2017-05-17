@extends('layouts.home')
@section('info')
    <title>Trav</title>
    <script type="text/javascript" src="{{asset('org/layer-v2.4/layer/layer.js')}}"></script>
@endsection
@section('content')
    <div class="main">
        <!--=======content================================-->

        <div class="content" style="padding-top: 20px;">
            <h3 style="padding-bottom: 10px;margin-bottom: 0;padding-left: 350px;">我的评论</h3>
                <div class="grid_9" style="width: 840px;">
                    @if(empty($dara))
                        <div style="font-size: 16px;padding-left: 100px;">暂无评论，去<a href="{{url('/sceinc/')}}">景点评论</a></div>
                    @endif
                    @foreach($data as $d)
                        <div class="blog" style="margin-top:20px;padding-top: 2px;width: 840px;">
                            <div class="extra_wrapper">
                                <div class="text1 upp" style="font-size: 14px;border-bottom: 1px solid black;">{{$d->us_name}}&nbsp;&nbsp;{{date('Y-m-d H:i:s',$d->tr_time)}}<a href="javascript:;" onclick="delTrav('{{$d->trav_id}}')" style="float: right;color: orangered;">删除</a></div>
                                <div class="contents" style="margin-top: 10px;padding-left: 20px;">
                                    <p>{{$d->tr_content}}</p>
                                    <div class="trav_img">
                                        @foreach($pic as $tp)
                                            @if($d->trav_id==$tp->tr_id)
                                                <img src="{{url($tp->tp_picture)}}" style="width: 202px;height: 150px;"/>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if(isset($d->re_id))
                                        <div style="margin-top: 1px;background: #CCC9C9;padding-left: 20px;padding-top: 5px;">
                                            管理员回复：<span>{{$d->re_content}}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    @endforeach
                        <div class="page_list">
                            {{$data->links()}}
                        </div>
                </div>
            <div class="grid_3" style="float: left; margin-left: 40px;">
                <h3>文章推荐</h3>
                <ul class="list2 l1">
                    @foreach($article_hot as $h)
                        <li><a href="{{url('/article/'.$h->art_id)}}" title="{{$h->art_tag}}">{{$h->art_title}} </a></li>
                    @endforeach
                </ul>
            </div>

                <div class="clear"></div>
            </div>
        </div>
    <script type="text/javascript">
        function delTrav(tr_id) {
            //询问框
            layer.confirm('你确定要删除这个评论吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('/trav')}}/"+tr_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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
