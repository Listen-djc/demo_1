@extends('layouts.home')
@section('info')
    <title>Home</title>
    <link rel="stylesheet" href="{{asset('home/style/css/slider.css')}}">
    <script src="{{asset('home/style/js/sForm.js')}}"></script>
    <script src="{{asset('home/style/js/jquery.jqtransform.js')}}"></script>
    <script src="{{asset('home/style/js/tms-0.4.1.js')}}"></script>
    <script src="{{asset('home/style/js/jquery-ui-1.10.3.custom.min.js')}}"></script>

    <script>
        $(window).load(function(){
            $('.slider')._TMS({
                show:0,
                pauseOnHover:false,
                prevBu:'.prev',
                nextBu:'.next',
                playBu:false,
                duration:800,
                preset:'random',
                pagination:false,//'.pagination',true,'<ul></ul>'
                pagNums:false,
                slideshow:8000,
                numStatus:false,
                banners:true,
                waitBannerAnimation:false,
                progressBar:false
            })	;
            $( "#tabs" ).tabs();

            $().UItoTop({ easingType: 'easeOutQuart' });
        });

    </script>

@endsection
@section('content')

    <div class="main">
        <div class="container_12">
            <div class="grid_12">
                <div class="slider-relative">
                    <div class="slider-block">
                        <div class="slider">
                            <a href="#" class="prev"></a><a href="#" class="next"></a>
                            <ul class="items">
                                @foreach($sceinc_pic as $v)
                                    <li><img src="{{url($v->sp_picture)}}" alt="" style=" height: 724px;width: 1128px;">
                                        <div class="banner">
                                            <div>最美南阳，南阳欢迎你！</div><br>
                                            <span> {{$v->sc_name}}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div></div>

        <!--=======content================================-->

        <div class="content">
            <div class="container_12">
                <div class="grid_12">
                    <h3>热门景点</h3>
                </div>
                <div class="boxes">
                    <?php $i=0; ?>
                    @foreach($sceinc_pic as $v)
                        @if($i==3)
                            @break
                            @endif
                    <div class="grid_4">
                        <figure>
                            <div><img src="{{url($v->sp_picture)}}" style="width: 360px;height: 270px;" alt=""></div>
                            <figcaption>
                                <h3>{{$v->sc_name}}</h3>
                                {!! $v->sc_introduce !!}
                                <a href="{{url('/sceinc/'.$v->sc_id)}}" class="btn">详情</a>						</figcaption>
                        </figure>
                    </div>
                            <?php $i++; ?>
                    @endforeach
                    <div class="clear"></div>
                </div>
                <div class="grid_8">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">精选路线</a></li>
                            <li><a href="#tabs-2">最新公告</a></li>
                            <li><a href="#tabs-3">最新文章</a></li>
                        </ul>
                        <div class="clear"></div>
                        <div class="tab_cont" id="tabs-1">
                            @foreach($route_new as $r)
                            <div class="extra_wrapper" style="padding-left: 30px;">
                                <div class="text1" style="padding: 5px 0 0 0;">{{$r->ro_name}} </div>
                                <span>包含景点：
                                    @foreach($sceinc_road as $s)
                                        @if($r->ro_id==$s->ro_id)
                                            {{$s->rm_type}}.&nbsp;{{$s->sc_name}}
                                        @endif
                                    @endforeach
                                </span><br/>
                                <span>行程天数：{{$r->ro_time}}天</span><br/>
                                <span>优惠开始时间：{{date('Y-m-d',$r->ro_pre_time)}}</span>
                                <div class="clear "></div>
                            </div>
                            <div class="clear cl1"></div>
                                @endforeach

                        </div>
                        <div class="tab_cont" id="tabs-2" style="text-align: center">
                            @foreach($notice_new as $n)
                            <div class="extra_wrapper" style="width: 700px;height: 171px;">
                                <div class="text1" style="padding: 5px 0;">{{$n->nt_title}}</div>
                              {!! $n->nt_content !!}
                                <p style="font-size: 12px;text-align: right;">发布时间{{date('Y-m-d H:i:s',$n->nt_time)}}</p>
                                <div class="clear "></div>
                            </div>
                                <div class="clear cl1"></div>
                            @endforeach

                        </div>
                        <div class="tab_cont" id="tabs-3">
                            @foreach($article_new as $k)
                                <img src="{{url($k->art_thumb)}}" alt="" style="width: 246px;height: 150px;">
                                <div class="extra_wrapper" style="width: 440px;height: 171px;">
                                    <div class="text1" style="padding: 5px 0;">{{$k->art_title}}</div>
                                    <p class="style1">{{$k->art_description}} </p>

                                    <a href="{{url('/article/'.$k->art_id)}}" class="btn">详情</a>
                                    <div class="clear "></div>

                                </div>
                                <div class="clear cl1"></div>
                            @endforeach
                        </div>
                        <style type="text/css">
                        </style>
                    </div>
                </div>

                <div class="grid_4">
                    <div class="newsletter_title">热门文章 </div>
                    <div class="n_container" style="margin-top: 40px;">
                        <ul class="list">
                            @foreach($article_hot as $h)
                            <li><a href="{{url('/article/'.$h->art_id)}}" title="{{$h->art_tag}}">{{$h->art_title}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="clear"></div></div>
        </div>
        <!--==============================footer=================================-->

    </div>

@endsection