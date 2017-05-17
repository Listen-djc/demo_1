@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 系统基本信息
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
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
                <a href="{{url('/admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="{{url('/admin/notice/create')}}"><i class="fa fa-plus"></i>新增公告</a>
                <a href="{{url('/admin/sceinc/create')}}"><i class="fa fa-plus"></i>新增景点</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->


    <div class="result_wrap">
        <div class="result_title">
            <h3>系统基本信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>操作系统</label><span>{{PHP_OS}}</span>
                </li>
                <li>
                    <label>运行环境</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                </li>
                <li>
                    <label>版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span><?php echo get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"; ?></span>
                </li>
                <li>
                    <label>北京时间</label><span class="nowTime"><?php echo date('Y-m-d H:i:s'); ?></span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span>{{$_SERVER['SERVER_NAME']}} [{{$_SERVER['SERVER_ADDR']}} ]</span>
                </li>
                <li>
                    <label>Host</label><span>{{$_SERVER['SERVER_ADDR']}}</span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>使用帮助</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>官方交流网站：</label><span><a href="#">http://***.com</a></span>
                </li>
                <li>
                    <label>官方交流QQ群：</label><span><a href="#"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png"></a></span>
                </li>
            </ul>
        </div>
    </div>
    <!--结果集列表组件 结束-->

    <script type="text/javascript">
        function showTime() {
            var timer = new Date(); //获得当前时间的事件对象

            //获得“年、月、日、时、分、秒”信息
            var year = timer.getFullYear();
            var month = setTime(timer.getMonth()+1);
            var date = setTime(timer.getDate());

            var hour = setTime(timer.getHours());
            var minute = setTime(timer.getMinutes());
            var second = setTime(timer.getSeconds());


            var s = year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second;
            //显示时间
            $('.nowTime').html(s);
        }
        //格式化 年月日，时分秒
        function setTime(stt) {
            if(stt<10){
                return '0'+stt;
            }else{
                return stt;
            }
        }
        $(function(){
            setInterval(showTime,1000);
        });
    </script>
@endsection