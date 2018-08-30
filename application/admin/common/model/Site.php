<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28 0028
 * Time: 下午 6:26
 */

namespace app\admin\common\model;
use think\Model;

class Site extends Model
{
    protected $pk ="id";
    protected $table = "gblc_site";
    protected $autoWriteTimestamp = true; //自动时间戳
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y年m月d日';
}