<?php
/**
 * gblc_user表的验证器
 */

namespace app\common\validate;

use think\Validate;
class User extends Validate
{
    protected $rule =[
        'name|姓名'=>'require|length:5,20|unique:gblc_user|chsAlphaNum',
        'email|邮箱'=>'require|email|unique:gblc_user',
        'mobile|手机号'=>'require|mobile|unique:gblc_user',
        'password|密码'=>'require|length:6,20|chsAlphaNum|confirm',
    ];
}