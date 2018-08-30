<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 下午 4:50
 */

namespace app\admin\common\model;
use think\Model;

class User extends Model
{
    protected $pk ="id";
    protected $table = "gblc_user";
    protected $autoWriteTimestamp = true; //自动时间戳
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y年m月d日';

    public function getStatusAttr($value)
    {
        $status = ['1'=>'启用','0'=>'禁用'];
        return $status[$value];
    }


}