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
                    <h3 style="margin-bottom: 20px;">{{$sceinc->sc_name}}</h3>
                    <div class="map">
                        <figure class="img_inner fleft">
                            <img src="{{url($sceinc->sp_picture)}}" style="width: 550px;height: 350px;">
                        </figure>
                        <address>
                            <div style="height: 100px;"></div>
                            <dl>
                                <dt style="margin-bottom: 1px;">
                                    关键词：&nbsp;&nbsp;{{$sceinc->sc_keyword}}
                                </dt>
                                <dt style="height: 160px;">
                                    景区介绍：&nbsp;&nbsp;{!! $sceinc->sc_introduce !!}
                                </dt>
                                                <dd><span>景区门票：</span><s>￥{{$sceinc->sc_price}}</s></dd>
                                                <dd><span>优惠价格：</span>￥{{$sceinc->sc_pre_price}}</dd>
                                                <dd><span>优惠开始时间：</span>{{date('Y-m-d H-i-s',$sceinc->sc_time)}}</dd>
                            </dl>
                        </address>

                    </div>
                    @if(isset(session('home_user')['us_id']))
                        <div style="text-align: right;margin-top: 20px;">
                            <a href="{{url('/trav/create').'?sc_id='.$sceinc->sc_id}}" class="btn" style="float: right;background-color: yellowgreen;">评论</a>
                        </div>
                    @endif
                </div>

                <div class="grid_3">
                    <h3>最新公告</h3>
                    <ul class="list2 l1">
                        <div style="border: 2px solid black; padding: 10px;">
                        @if(!empty($notice))
                                <p style="text-align: center">{{$notice->nt_title}}<p>
                                {!! $notice->nt_content !!}
                                <p style="text-align: right;margin-bottom: 0;">发布时间：{{date('Y-m-d H:i:s',$notice->nt_time)}}</p>
                            @else
                                <p style="padding-left: 10px;margin-bottom: 0;">暂无公告<p>
                            @endif
                        </div>
                    </ul>
                </div>

                <div class="grid_9">
                    @foreach($trav as $t)
                        <div class="blog" style="margin-top:20px;padding-top: 2px;">
                            <div class="extra_wrapper">
                                <div class="text1 upp" style="font-size: 14px;border-bottom: 1px solid black;">{{$t->us_name}}&nbsp;&nbsp;{{date('Y-m-d H:i:s',$t->tr_time)}}</div>
                                <div class="contents" style="margin-top: 10px;padding-left: 20px;">
                                    <p>{{$t->tr_content}}</p>
                                    <div class="trav_img">
                                        @foreach($trav_pic as $tp)
                                            @if($t->trav_id==$tp->trav_id)
                                                <img src="{{url($tp->tp_picture)}}" style="width: 202px;height: 150px;"/>
                                                @endif
                                        @endforeach
                                    </div>
                                    @if(isset($t->re_id))
                                        <div style="margin-top: 1px;background: #CCC9C9;padding-left: 20px;padding-top: 5px;">
                                            管理员回复：<span>{{$t->re_content}}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    @endforeach
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection