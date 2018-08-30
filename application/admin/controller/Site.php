<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28 0028
 * Time: 下午 6:29
 */

namespace app\admin\controller;

use app\admin\common\controller\Base;
use app\admin\common\model\Site as SiteModel;
use app\admin\common\model\Article as ArticleModel;
use think\facade\Request;
use think\facade\Session;
class Site extends Base
{
    public function index(){
        $siteInfo = SiteModel::get(['status'=>1]);

        $this->view->assign('siteInfo',$siteInfo);

        return $this->view->fetch('index');
    }

    public function save(){
        $data = Request::param();

        if (SiteModel::update($data)){
            $this->success('更新成功','index');
        }
        $this->error('更新失败','index');
    }
}