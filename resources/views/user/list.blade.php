<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/js/layer/jquery.js"></script>
    <script src="/js/layer/layer.js"></script>
    <title>列表显示页面</title>
</head>
<body>
<table>
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>密码</td>
        <td>操作</td>
    </tr>
    @foreach($user as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->username}}</td>
            <td>{{$v->password}}</td>
            <td><a href="/user/edit/{{$v->id}}">修改</a> <a href="javascript:void(0);" onclick="del_member(this,{{$v->id}});">删除</a></td>
        </tr>
    @endforeach
</table>
<script>
    function del_member(obj,id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.get('/user/del/'+id,function (data) {
                if (data.status == 0) {
                    $(obj).parents('tr').remove();
                    layer.msg(data.msg, {icon: 1});
                } else {
                    layer.msg(data.msg, {icon: 2});
                }
            })
        }, function () {

        });
    }

</script>
</body>
</html>