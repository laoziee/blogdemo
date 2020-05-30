<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogUser extends Model
{
    /**
     * 关联表
     */
    protected $table = 'blog_user';

    public $incrementing=false;

    /**
     * 关联表主键
     */
    public $primaryKey = 'user_id';

    /**
     * 允许被操作的字段
     * @var array
     */
    protected $fillable = [
        'user_name','user_pass'
    ];

    /**
     * 禁用时间戳
     * @var bool
     */
    public $timestamps = false;
}
