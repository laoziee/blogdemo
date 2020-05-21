<?php

namespace App\Http\Controllers;

use App\BlogUser;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * 显示用户信息
     * @return view
     */
    public function index()
    {
        $user =BlogUser::get();
        //dd($user);
        /*return view('user.list',['user'=>$user]);*/
        return view('user.list')->with('user',$user);
        //return view('user.list',compact('user'));
    }
    
    /**
     * 获取一个添加页面
     * @param null
     * @return 返回模板页面
     */
    public function add()
    {
        return view('user.add');
    }

    /**
     * 执行用户提交的数据
     * @param 提交的数据
     * @return 返回执行是否成功
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $res = BlogUser::create(['username'=>$input['username'],'password'=>md5($input['password'])]);
        //$res = BlogUserModel::create($input);
        if ($res) {
            return redirect('user/index');
        } else {
            return back();
        }
    }

    /**
     * 修改页面
     */
    public function edit($id)
    {
        $user = BlogUser::find($id);
        return view('user.edit',compact('user'));
    }

    /**
     * 执行修改操作
     */
    public function update(Request $request)
    {
        $input = $request->post();
        $user = BlogUser::find($input['id']);
        $res = $user->update(['username'=> $input['username']]);
        if ($res) {
            return redirect('user/index');
        } else {
            return back();
        }
    }

    /**
     * 删除操作
     */
    public function destroy($id)
    {
        $user = BlogUser::find($id);
        if (!$user) {
            return [
                'status' => -1,
                'msg'    => '参数错误'
            ];
        }
        $res = $user->delete();
        if ($res) {
            $data = [
                'status' => 0,
                'msg'    => '删除成功'
            ];
        } else {
            $data = [
              'status' => 1,
              'msg'    => '删除失败'
            ];
        }
        return $data;
    }
}
