<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20 0020
 * Time: 下午 7:33
 */

namespace app\common\validate;
use think\Validate;

class Article extends Validate
{

    protected $rule =[
        'title|标题'=>'require|length:5,20|chsAlphaNum',
        'content|逼逼内容'=>'require',
        'user_id|作者'=>'require',
        'cate_id|栏目名称'=>'require',
    ];
}