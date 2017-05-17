<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Login</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="{{asset('home/style/js/jquery-1.9.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/style/js/login.js')}}"></script>
<link href="{{asset('home/style/css/login2.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>南阳旅游网<sup>2017</sup></h1>

<div class="login" style="margin-top:50px;">
    
    <div class="header">
        <div class="switch" id="switch">
            <a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);" tabindex="7">快速登录</a>
			<a class="switch_btn" id="switch_login" href="javascript:void(0);" tabindex="8">快速注册</a>
            <div class="switch_bottom" id="switch_bottom" style="position: absolute; width: 64px; left: 0px;"></div>
        </div>
    </div>    
  
    
    <div class="web_qr_login" id="web_qr_login" style="display: block; height: 315px;">

            <!--登录-->
            <div class="web_login" id="web_login">
               
               
               <div class="login-box">
    
            
			<div class="login_form">
				<form action="{{url('/login')}}" name="loginform" accept-charset="utf-8" id="login_form" class="loginForm" method="post">
                    {{csrf_field()}}
               <input type="hidden" name="to" value="log"/>
                    @if(count($errors)>0)
                        @if(is_object($errors))
                            @foreach($errors->all() as $v)
                                <div id="userCue" class="cue"  style="height: 20px;text-align: center;color: red;">{{$v}}</div>
                            @endforeach
                        @else
                            <div id="userCue" class="cue"  style="height: 20px;text-align: center;color: red;">{{$errors}}</div>
                        @endif
                    @endif
                <div class="uinArea" id="uinArea">
                    <label class="input-tips" for="u">姓名：</label>
                    <div class="inputOuter" id="uArea">
                        <input type="text" id="u" name="user_name" class="inputstyle"/>
                    </div>
                </div>

                <div class="pwdArea" id="pwdArea">
                   <label class="input-tips" for="p">密码：</label>
                   <div class="inputOuter" id="pArea">
                        <input type="password" id="p" name="user_passwd" class="inputstyle"/>
                    </div>
                </div>

                    <div class="pwdArea" id="pwdArea">
                        <label class="input-tips" for="p" style="width: 70px;margin-top:0px; ">验证码：</label>
                        <div style="">
                            <input type="text" name="code"  class="inputstyle" style="width: 60px; height: 42px;"/>
                            <img src="{{url('/code')}}" alt="" onclick="this.src='{{url('/code')}}?'+Math.random()" style="height: 42px;width: 110px; display: inline-block; margin-bottom: -13px;" >
                        </div>
                    </div>
               
                <div style="padding-left:50px;margin-top:20px;"><input type="submit" value="登 录" style="width:150px;" class="button_blue"/><a href="{{url('/')}}" class="zcxy">返回首页</a></div>
              </form>
           </div>
           
            	</div>
               
            </div>
            <!--登录end-->
  </div>

  <!--注册-->
    <div class="qlogin" id="qlogin" style="display: none; ">
   
    <div class="web_login" style="padding-bottom: 10px;margin-bottom: 20px;">
        <form name="form2" id="regUser" accept-charset="utf-8"  action="{{url('/register')}}" method="post">
            {{csrf_field()}}
        <ul class="reg_form" id="reg-ul">
            @if(count($errors)>0)
                @if(is_object($errors))
                    @foreach($errors->all() as $v)
                        <div id="userCue" class="cue"  style="height: 20px;text-align: center;color: red;">{{$v}}</div>
                    @endforeach
                @else
                    <div id="userCue" class="cue"  style="height: 20px;text-align: center;color: red;">{{$errors}}</div>
                @endif

            @else
                <div id="userCue" class="cue" style="height: 20px;">快速注册请注意格式</div>
            @endif
                <li>
                	
                    <label for="user"  class="input-tips2">用户名：</label>
                    <div class="inputOuter2">
                        <input type="text" id="user" name="name" maxlength="16"  placeholder="用户姓名必须填写（3-16）" class="inputstyle2"/>
                    </div>
                    
                </li>
                
                <li>
                <label for="passwd" class="input-tips2">密码：</label>
                    <div class="inputOuter2">
                        <input type="password" id="passwd"  name="password" placeholder="密码必须填写（6-20）" maxlength="20" class="inputstyle2"/>
                    </div>
                    
                </li>
                <li>
                <label for="passwd2" class="input-tips2">确认密码：</label>
                    <div class="inputOuter2">
                        <input type="password" id="passwd2" name="password_confirmation" placeholder="确认密码必须和密码一致" maxlength="20" class="inputstyle2" />
                    </div>
                    
                </li>

                <li>
                    <label for="qq" class="input-tips2">性别：</label>
                    <div class="inputOuter2" style="height: 30px;margin-top: 10px;line-height: 30px;font-size: 16px;">
                        <input type="radio"  name="sex" checked="checked" value="男"/>男
                        <input type="radio"  name="sex" value="女"/>女
                    </div>

                </li>
                
                <li>
                 <label for="qq" class="input-tips2">用户电话：</label>
                    <div class="inputOuter2">

                        <input type="text" id="qq" name="phone" maxlength="15" placeholder="用户电话不得为空(6-15)" class="inputstyle2"/>
                    </div>

                </li>
                <li>
                    <label for="qq" class="input-tips2">Email：</label>
                    <div class="inputOuter2">

                        <input type="text" id="qq" name="email" maxlength="20"  placeholder="Email不能超过20" class="inputstyle2"/>
                    </div>

                </li>
                <li>
                    <label for="qq" class="input-tips2">验证码：</label>
                    <div style="">
                        <input type="text" name="code"  class="inputstyle" style="width: 60px; height: 42px;"/>
                        <img src="{{url('/code')}}" alt="" onclick="this.src='{{url('/code')}}?'+Math.random()" style="height: 42px;width: 110px; display: inline-block; margin-bottom: -13px;" >
                    </div>
                </li>
                
                <li>
                    <div class="inputArea">
                        <input type="submit"  style="margin-top:10px;margin-left:85px;width: 150px;" class="button_blue" value="注册"/> <a href="{{url('/')}}" class="zcxy" >返回首页</a>
                    </div>
                    
                </li><div class="cl"></div>
            </ul></form>
           
    
    </div>
   
    
    </div>
    <!--注册end-->
</div>
</body>
<script type="text/javascript">
    $(function (){
        if("{{isset($register)}}"){
            $('#web_qr_login').css('display','none');
            $('#qlogin').css('display','block');
            $('#switch_bottom').css('left','154px');
        }
    })
</script>
</html>