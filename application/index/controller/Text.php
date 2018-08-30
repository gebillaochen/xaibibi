<?php
/**
 * 测试专用控制器
 */

namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\User;
class Text extends Base
{
    //测试用户验证类
    public function test1(){
        dump(User::get(1));
    }
    public function base(){
        $this->view->fetch('base');
    }
}