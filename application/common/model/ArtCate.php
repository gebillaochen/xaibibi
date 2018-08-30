<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20 0020
 * Time: 下午 8:03
 */

namespace app\common\model;
use think\Model;

class ArtCate extends Model
{
    protected $pk = 'id'; //默认主键
    protected $table = 'gblc_article_cg'; //默认数据表

    protected $autoWriteTimestamp = true; //自动时间戳
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y年m月d日';

    //开启自动设置
    protected $auto = [];
    //仅新增有效
    protected $insert = ['create_time','status'=>1];
    //仅更新有效
    protected $update = ['update_time'];
}