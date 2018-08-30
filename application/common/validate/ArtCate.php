<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20 0020
 * Time: 下午 8:06
 */

namespace app\common\validate;
use think\facade\Validate;

class ArtCate extends Validate
{
    protected $rule =[
        'name|栏目名称'=>'require|length:3,20|unique:gblc_user|chsAlpha'
    ];
}