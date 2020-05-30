<?php

namespace App\Http\Controllers\admin;

use App\model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$input = $request->all();

        //$users = User::paginate(3);
        $users = User::orderBy('user_id', 'asc')
            ->where(function ($query) use ($request) {
                if (!empty($request->input('username'))) {
                    $query->where('user_name', 'like', '%' . $request->input('username') . '%');
                }
                if (!empty($request->input('email'))) {
                    $query->where('email', 'like', '%' . $request->input('email') . '%');
                }
            })->paginate($request->input('num') ?? 3);
        return view('admin.user.list', compact('users', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $pass = Crypt::encrypt($input['repass']);
        $res = User::create(['user_name' => $input['username'], 'email' => $input['email'], 'user_pass' => $pass]);
        if ($res) {
            $data = [
                'status' => 0,
                'message' => '添加成功'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '添加失败'
            ];
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //根据id获取修改数据
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $user = User::find($id);

        if (!empty( $request->input('user_name') )) {
            $user->user_name = $request->input('user_name');
        }

        $user->email = $request->input('email');
        $user->user_pass = Crypt::encrypt($request->input('repass'));

        $res = $user->save();
        if ($res) {
            $result = [
                'status' => 0,
                'message' =>'修改成功'
            ];
        } else {
            $result = [
                'status' => 1,
                'message' =>'修改失败'
            ];
        }
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $res = $user->delete();
        if ($res) {
            $result = [
                'status' => 0,
                'message' =>'已删除!'
            ];
        } else {
            $result = [
                'status' => 1,
                'message' =>'删除失败'
            ];
        }
        return $result;
    }

    /**
     * 批量删除
     */
    public function delAll(Request $request)
    {
        $ids = $request->input('ids');
        $res = User::destroy($ids);
        if ($res) {
            $result = [
                'status' => 0,
                'message' =>'已删除!'
            ];
        } else {
            $result = [
                'status' => 1,
                'message' =>'删除失败'
            ];
        }
        return $result;
    }
    
    /**
     * 修改密码
     *
     */
    public function resetpwd()
    {

    }

}
