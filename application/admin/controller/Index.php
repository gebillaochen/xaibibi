<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 下午 3:54
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;

class Index extends Base
{
    public function Index(){
        //用户是否登陆
        $this->Logined();
        $this->success('正在跳转！','admin/user/userList');
    }
}