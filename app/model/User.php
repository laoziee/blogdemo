<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //关联数据库表
    public $table = 'blog_user';

    //主键
    public $primaryKey = 'user_id';

    //允许操作的字段
    //public $fillable = ['user_name','user_pass','email','phone'];

    //不允许操作的字段
    public $guarded = [];

    //是否操作create_at 和 update_at 字段
    public $timestamps = false;

}
