@extends('layouts.home')
@section('info')
    <title>Article</title>
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
                    <div class="">
                        <h3>{{$article->art_title}}</h3>
                        <img src="{{url($article->art_thumb)}}" alt="" class="img_inner fleft" style="width: 360px;height: 280px;">
                        <p class="text1">作者：{{$article->art_editor}}&nbsp;&nbsp;
                            景区：<a href="{{url('sceinc/'.$article->sc_id)}}">{{$article->sc_name}}</a></p>
                        {!! $article->art_content !!}
                        关键词：{{$article->art_tag}}
                        <div class="article_footer" style="text-align: right">
                            <span>浏览次数：{{$article->art_view}}</span><br/>
                            <span>时间：{{date('Y-m-d H:i:s',$article->art_time)}}</span>
                        </div>
                        <div class="clear"></div>

                    </div>
                </div>
                <div class="grid_3">
                    <h3>类似文章</h3>
                    <ul class="list1">
                        <?php $i=0; ?>
                        @foreach($data as $h)
                        <li>
                            <div class="count"><?php $i++;echo $i; ?></div>
                            <div class="extra_wrapper">
                                <div class="text1"><a href="{{'/article/'.$h->art_id}}">{{$h->art_title}} </a></div>{{$h->art_description}}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="grid_12">
                    <div class="hor_sep"></div>
                </div>
                <div class="clear"></div>
                <div style="padding-top: 10px;">
                    @if($article['pre'])
                        <p style="margin: 0">上一篇：<a href="{{url('/article/'.$article['pre']->art_id)}}">{{$article['pre']->art_title}}</a></p>
                    @else
                        <span>没有上一篇了</span>
                    @endif
                    @if($article['next'])
                        <p style="margin: 0">下一篇：<a href="{{url('/article/'.$article['next']->art_id)}}">{{$article['next']->art_title}}</a></p>
                    @else
                        <span>没有下一篇了</span>
                    @endif
                </div>
            </div>
        </div>


    </div>
@endsection