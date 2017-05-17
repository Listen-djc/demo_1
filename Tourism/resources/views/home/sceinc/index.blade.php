@extends('layouts.home')
@section('info')
    <title>Tours</title>
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
                    <h3>全部景区</h3>
                    <div class="tours">
                        @foreach($sceinc as $s)
                        <div class="grid_4 alpha" style="margin-top: 10px;">
                            <div class="tour">
                                <img src="{{url($s->sp_picture)}}" alt="" class="img_inner fleft" style="width: 167px;height: 143px;">
                                <div class="extra_wrapper">
                                    <p class="text1">{{$s->sc_name}} </p>
                                    <p class="price">原价：<span><s>￥{{$s->sc_price}}</s></span></p>
                                    <p class="price" style="margin-bottom: 5px;">优惠价： <span>￥{{$s->sc_pre_price}}</span>
                                        <a href="{{url('/sceinc/'.$s->sc_id)}}" class="btn" style="float: right;">详情</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="clear"></div>
                            <div class="page_list">
                                {{$sceinc->links()}}
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