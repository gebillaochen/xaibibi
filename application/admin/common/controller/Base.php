<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 下午 4:42
 */

namespace app\admin\common\controller;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    //初始化方法
    protected function initialize()
    {

    }

    //监测用户是否登陆
    public function Logined(){
        if (!Session::has('user_id')){
            $this->error('请先登陆','admin/user/login');
        }
    }

    //防止重复登陆
    public function isLogin(){
        if (Session::has('user_id')){
            $this->error('您已经登陆了','index/index');
        }
    }
    //判断是否是管理员
    public function is_admin_login(){
        $this->Logined();
        if (Session::get("is_admin")!==1){
            $this->error('您没有权限访问该网址','admin/index/index');
        }
    }
}