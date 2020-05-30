<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /**
     * 后台主页
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * 统计页面
     */
    public function total()
    {
        return view('admin.welcome1');
    }
}
