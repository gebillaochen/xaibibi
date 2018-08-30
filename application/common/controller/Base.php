<?php
/**
 * 基础控制器
 * 必须继承自think\Controller
 */

namespace app\common\controller;

use think\Controller;
use think\facade\Session;
use app\common\model\ArtCate;
use app\common\model\Article;
use app\admin\common\model\Site;
use think\facade\Request;
class Base extends Controller
{
    /**
     * 初始化方法
     * 创建常量，公共方法
     * 在所有的方法之前被调用
     */
    protected function initialize()
    {
        //显示分类导航
        $this->showNav();
        $this->is_open();
        $this->getHotArt();
    }

    //监测是否登陆
    public function Logined(){
        if (!Session::has('user_id')){
            $this->error('请先登陆','user/login');
        }
    }

    //防止重复登陆
    public function isLogin(){
        if (Session::has('user_id')){
            $this->error('您已经登陆了','index/index');
        }
    }

    public function showNav(){
        //查询分类表获取到所有的分类信息
        $cateList = ArtCate::all(function ($query){
            $query->where('status',1)->order('sort','asc');
        });
        //将分类信息赋值给模板
        $this->view->assign('cateList',$cateList);
    }

    public function is_open(){
        $isOpen=Site::where('status',1)->value('is_open');

        if ($isOpen==0 && Request::module()=='index'){
            $info = <<<'INFO'
            <body style="background-color: #333">
            <h1 style="color: #eee;text-align:center;margin:200px">站点维护中</h1>
</body>
INFO;

            exit($info);
        }
    }

    public function is_reg(){
        $isReg=Site::where('status',1)->value('is_reg');

        if ($isReg==0){
            $this->error('注册功能已经关闭','index/index');
        }
    }

    public function getHotArt(){
        $hotArtList=Article::where('status',1)->order('pv','desc')->limit(10)->select();
        $this->view->assign('hotArtList',$hotArtList);
    }
}