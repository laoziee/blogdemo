<?php

namespace App\Http\Controllers\admin;

use App\model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * 登录页面
     */
    public function login()
    {
        return view('admin.login');
    }

    public function test()
    {

        $arr1 = ["id", "name"];
        $arr2 = [ [100, "Tom"], [101, "Jane"] , [102, "Tom"]  ] ;

        // $res = array_combine($arr1,$arr2);  //{"id":[100,"Tom"],"name":[101,"Jane"]}

        //$res = $this->rs2array($arr1,$arr2);   //[{"id":100,"name":"Tom"},{"id":101,"name":"Jane"}]

        $res = $this->rs2MultiHash($arr1,$arr2,'name');
        //{"Tom":[{"id":100,"name":"Tom"},{"id":102,"name":"Tom"}],"Jane":[{"id":101,"name":"Jane"}]}
        return $res;

    }

    /**
    @fn rs2Array(rs)

    @param rs对象，格式为 {h, d}, h/d分别是一个数组，表示一张表的表头字段与内容。
    @return 一个数组，每一项为一个对象。

    示例：

    var rs = {
    h: ["id", "name"],
    d: [ [100, "Tom"], [101, "Jane"] ]
    };
    var arr = rs2Array(rs);

    // 结果为
    arr = [
    {id: 100, name: "Tom"},
    {id: 101, name: "Jane"}
    ];

     */
    function rs2array($arr1,$arr2){
        $new_arr = [];
        foreach($arr1 as $k=>$v) {
            foreach ($arr2 as $kk=>$vv){
                $new_arr[$kk][$v] = $vv[$k];
            }
        }
        return $new_arr;
    }



    /**
    @fn rs2MultiHash(rs, key)

    @param rs对象，格式为 {h, d}, h/d分别是一个数组，表示一张表的表头字段与内容。
    @return 一个对象，内容是键值对。

    示例：

    var rs = {
    h: ["id", "name"],
    d: [ [100, "Tom"], [101, "Jane"], [102, "Tom"] ]
    };
    var hash = rs2MultiHash(rs, "name");

    // 结果为
    hash = {
    "Tom": [{id: 100, name: "Tom"}, {id: 102, name: "Tom"}],
    "Jane": [{id: 101, name: "Jane"}]
    };

    参数key为"name"，表示将rs对象中"name"字段作为键值，将名字相同的对象组织到同一个"name"字段对象的值数组中。
     */
    function rs2MultiHash($arr1,$arr2,$key){
        $new_arr = [];
        foreach($arr1 as $k=>$v) {
            foreach ($arr2 as $kk => $vv) {
                $new_arr[$kk][$v] = $vv[$k];
            }
        }
        $res_arr = [];
        foreach($new_arr as $keys=>$val) {
            $res_arr[$val[$key]][] = $val;
        }

        return $res_arr;
    }
    
    /**
     * 登录处理
     */
    public function todoLogin(Request $request)
    {
        //dd($request->all());
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_name' => 'required|between:2,18',
            'user_pass' => 'required|alpha_dash|between:5,18',
            'captcha'  => 'required|captcha',
        ]);
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('user_name',$input['user_name'])->first();

        if (!$user) {
            return redirect('admin/login')->with('errors','用户不存在');
        }

        if ($input['user_pass'] != Crypt::decrypt($user->user_pass)) {
            return redirect('admin/login')->with('errors','密码错误');
        }

        session()->put('user',$user);
        return redirect('admin/main');
    }


    /**
     *设置加密串
     */
    public function setCrypt()
    {
        $str = '123456';
        $code = Crypt::encrypt($str);
        /*if ($str = Crypt::decrypt($code)){
            return '密码一致';
        }*/
        dd($code);
    }

    /**
     * 后台欢迎页面
     *
     */
    public function welcome()
    {
        return view('admin.welcome');
    }

    /**
     * 登出方法
     *
     */
    public function logout()
    {
        session()->flash('user');
        return redirect('admin/login');
    }

}
