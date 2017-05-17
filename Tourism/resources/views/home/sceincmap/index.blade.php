@extends('layouts.home')
@section('info')
    <title>Route</title>
    <script>
        $(window).load(function(){
            $().UItoTop({ easingType: 'easeOutQuart' });
        });
    </script>


@endsection
@section('content')
    <div class="main">
        <!--=======content================================-->

        <div class="content">
            <div class="container_12">
                <div class="grid_9">
                    <h3>旅游路线</h3>
                    <div class="tours" style="width: 80%;">
                        @foreach($data as $d)
                            <div class="grid_4 alpha" style="margin-top: 10px;width: 80%;margin-bottom: 20px;">
                                <div class="tour">
                                    <img src="{{url($sceinc_road[0]->sp_picture)}}" alt="" class="img_inner fleft" style="width: 167px;height: 143px;">
                                    <div class="extra_wrapper">
                                        <p class="text1">
                                            {{$d->ro_name}}
                                        </p>
                                        <p style="margin-bottom: 0;height: 40px;">路线景点：
                                            @foreach($sceinc_road as $s)
                                                @if($d->ro_id==$s->ro_id)
                                                    {{$s->rm_type}}.&nbsp;{{$s->sc_name}}
                                                @endif
                                            @endforeach
                                        </p>
                                        <p style="margin-bottom: 0;">路线时间：{{$d->ro_time}}天</p>
                                        <p style="margin-bottom: 0;">优惠开始时间：{{date('Y-m-d H:i:s',$d->ro_pre_time)}}</p>
                                        <p style="margin-bottom: 0;">原价：<span style="color: #00a2d4"><s>￥{{$d->ro_price}}</s></span></p>
                                        <p style="margin-bottom: 0;">优惠价： <span style="color: #00a2d4">￥{{$d->ro_pre_price}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clear"></div>
                        <div class="page_list">
                            {{$data->links()}}
                        </div>
                    </div>
                </div>
                <div class="grid_3">
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

    </div>
@endsection