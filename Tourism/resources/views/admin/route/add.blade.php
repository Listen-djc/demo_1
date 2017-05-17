@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加景区
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/sceinc/create')}}"><i class="fa fa-plus"></i>添加景区</a>
                <a href="{{url('admin/sceinc/')}}"><i class="fa fa-recycle"></i>全部景区</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/sceinc')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>景区名称：</th>
                    <td>
                        <input type="text" name="sc_name">
                        <span><i class="fa fa-exclamation-circle yellow"></i>景区名称必须填写</span>
                    </td>
                </tr>

                <tr>
                    <th><i class="require"></i>景区价格（成人）：</th>
                    <td>
                        <input type="text" class="sm" name="sc_price">
                    </td>
                </tr>

                <tr>
                    <th><i class="require"></i>优惠后价格</th>
                    <td>
                        <input type="text" class="sm" name="sc_pre_price">
                    </td>
                </tr>
                <tr>
                    <th>状态：</th>
                    <td>
                        <select name="sc_status">
                            <option value="1">正常使用</option>
                            <option value="0">停止使用</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>景区负责人：</th>
                    <td>
                        <select name="ad_id">
                            @foreach($admin as $u)
                                <option value="{{$u->ad_id}}">{{$u->ad_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" size="50" name="sp_picture">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#file_upload').uploadify({
                                    'buttonText' : '图片上传',
                                    'formData'     : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        '_token'     : "{{csrf_token()}}"
                                    },
                                    'swf'      : "{{asset('org/uploadify/uploadify.swf')}}",
                                    'uploader' : "{{url('admin/upload')}}",
                                    'onUploadSuccess' : function (file,data,response) {
                                        $('input[name=sp_picture]').val(data);
                                        $('#art_thumb_img').attr('src',"{{asset('/')}}"+data);
                                    }
                                });
                            });
                        </script>
                        <style>
                            .uploadify{display:inline-block;}
                            .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                            table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                        </style>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <img src="" alt="" id="art_thumb_img" style="max-width: 300px;max-height: 100px"/>
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>景区关键词：</th>
                    <td>
                        <input type="text" class="lg" name="sc_keyword">
                        <span><i class="fa fa-exclamation-circle yellow"></i>关键词必须填写(6-20)</span>
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>景区介绍：</th>
                    <td>
                        <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="sc_introduce" type="text/plain" style="width:860px;height:500px;"></script>
                        <script type="text/javascript">
                            var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                        <span><i class="fa fa-exclamation-circle yellow"></i>景区介绍必须填写</span>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection
