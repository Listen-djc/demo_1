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
                    <h3>全部文章</h3>
                    @foreach($article as $a)
                        <div class="blog" style="margin-top:30px;padding-top: 1px;">
                        <time datetime="{{date('Y-m-d',$a->art_time)}}" style="line-height: 20px;">{{date('m-d',$a->art_time)}}</time>
                        <div class="extra_wrapper">
                            <div class="text1 upp">{{$a->art_title}}</div>
                            <div class="links">作者<a href="#">{{$a->art_editor}}</a><a  class="comment">阅读量：{{$a->art_view}}</a></div>
                        </div>
                        <div class="clear"></div>
                        <img src="{{url($a->art_thumb)}}" alt="" class="img_inner fleft" style="width: 185px;height: 120px;">
                        <div class="extra_wrapper">
                            <p></p>
                            <p class="text1">{{$a->art_description}} </p>
                            <a href="{{url('/article/'.$a->art_id)}}" class="btn" style="float: right;">阅读全文</a>
                        </div>
                    </div>
                    @endforeach
                    <div class="page_list">
                            {{$article->links()}}
                    </div>
                </div>
                <div class="grid_3">
                    <h3>热门推荐</h3>
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