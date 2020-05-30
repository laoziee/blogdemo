@include('admin.public.header')
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">管理登录</div>
    <div id="darkbannerwrap"></div>

    <form action="/admin/dologin" method="post" class="layui-form">
        {{csrf_field()}}

        <input name="user_name" placeholder="用户名" type="text" lay-verify="required" class="layui-input">

        @if (!is_object($errors))
            <div class="alert alert-danger">
                <ul>
                    <li>{{ $errors }}</li>
                </ul>
            </div>
        @endif

        @if(is_object($errors) && $errors->has('user_name'))
            <div class="col-md-12">
                <p class="text-danger text-left"><strong>{{$errors->first('user_name')}}</strong></p>
            </div>
        @endif

        <hr class="hr15">
        <input name="user_pass" lay-verify="required" placeholder="密码" type="user_pass" class="layui-input">
        @if(is_object($errors) && $errors->has('user_pass'))
            <div class="col-md-12">
                <p class="text-danger text-left"><strong>{{$errors->first('user_pass')}}</strong></p>
            </div>
        @endif

        <hr class="hr15">
        <div class="row">
            <div class="col-md-pull-6">
                <input type="text" style="width: 180px;"
                       class="form-control {{is_object($errors) && $errors->has('captcha')?'parsley-error':''}}" name="captcha"
                       placeholder="请输入验证码">
                <img src="{{captcha_src()}}" style="cursor: pointer"
                     onclick="this.src='{{captcha_src()}}'+Math.random()">
            </div>

            @if(is_object($errors) && $errors->has('captcha'))
                <div class="col-md-12">
                    <p class="text-danger text-left"><strong>{{$errors->first('captcha')}}</strong></p>
                </div>
            @endif
        </div>

        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20">
    </form>
</div>

<script>
    $(function () {
        layui.use('form', function () {
            var form = layui.form;
            // layer.msg('玩命卖萌中', function(){
            //   //关闭后的操作
            //   });
            //监听提交
            form.on('submit(login)', function (data) {
                // alert(888)
                /*layer.msg(JSON.stringify(data.field),function(){
                    //location.href='index.html'
                });
                return false;*/
                $.ajax({
                    type: 'POST',
                    url: '/admin/dologin',
                    data: JSON.stringify(data.field),
                    dataType: "json",
                    success: function (res) {
                        if (res.status == 0) {
                            //登录成功
                            layer.msg(JSON.stringify(res), function () {
                                location.href = 'index.html'
                            });
                        } else {
                            //登录失败
                            console.log(res);

                        }
                    }
                });

                /*$.ajax({
                    method: 'POST',
                    url: "{{--{{ route('dologin') }}--}}",
                      dataType: 'json',
                      data: JSON.stringify(data.field),
                      success: function( res ) {
                          console.log(res);
                      }
                  });*/

            });
        });
    })
</script>
<!-- 底部结束 -->
@include('admin.public.footer')
</body>
</html>