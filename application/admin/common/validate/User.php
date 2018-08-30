<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/26 0026
 * Time: 下午 4:28
 */

namespace app\admin\common\validate;

use think\Validate;
class User extends Validate
{
    protected $rule =[
        'password|密码'=>'require|length:6,20|chsAlphaNum|confirm',
    ];
}