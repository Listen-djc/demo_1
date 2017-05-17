@extends('layouts.home')
@section('info')
    <title>Trav</title>
@endsection
@section('content')
<style>
    .result_wrap{ width: 400px; margin: 0 auto; margin-bottom: 80px;}
    .add_tab tr th{/* padding-bottom: 10px;  */text-align: center; line-height:40px;}
    .wenz{ line-height: 50px;}
  

</style>
    <div class="result_wrap">
        <div class="result_title" style="color: red;">
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
        <form action="{{url('/trav')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120" class="wenz">文章景区：</th>
                    <td>
                        <select name="sc_id">
                            <option value="{{$data->sc_id}}" >{{$data->sc_name}}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>文章内容：</th>
                    <td>
                        <textarea name="tr_content" maxlength="140" style="width: 248px;height: 112px;resize: none;"></textarea>
                    </td>
                </tr>

                <tr>
                    <th>缩略图：</th>
                    <td id="picture">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#file_upload').uploadify({
                                    'buttonText' : '图片上传',
                                    'fileExt': '*.jpg;*.jpeg;;*.png',
                                    'multi':true,
                                    'simUploadLimit':4,
                                    'queueSizeLimit':4,
                                    'formData'     : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        '_token'     : "{{csrf_token()}}"
                                    },
                                    'swf'      : "{{asset('org/uploadify/uploadify.swf')}}",
                                    'uploader' : "{{url('admin/upload')}}",
                                    'onUploadSuccess' : function (file,data,response) {
                                        $('#picture').append('                                        <input type="hidden" size="50" name="tp_picture[]" value="'+data+'">');
                                        $('#art_img').append('                                        <img alt="" src="'+"{{asset('/')}}"+data+'" style="max-width: 300px;max-height: 100px"/>');
                                        if($('#art_img img').length>=4){
                                            $('#file_upload').remove();
                                        }

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
                    <td id="art_img">
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
