<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改页面</title>
</head>
<body>
<form action="{{url('/user/update')}}" method="post">
    <table>
        <tr>
            {{csrf_field()}}
            {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
            <input type="hidden" name="id" value="{{$user->id}}">
            <td>用户名</td>
            <td><input type="text" name="username" value="{{$user->username}}"></td>
        </tr>
        <tr>
            <td><input type="submit" name="修改"></td>
        </tr>
    </table>
</form>
</body>
</html>