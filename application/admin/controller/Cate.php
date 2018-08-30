<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27 0027
 * Time: 上午 11:09
 */

namespace app\admin\controller;

use app\admin\common\controller\Base;
use app\admin\common\model\Cate as CateModel;
use think\facade\Request;
use think\facade\Session;
class Cate extends Base
{
    public function index(){
        $this->is_admin_login();
        return $this->redirect('cateList');
    }

    public function cateList(){
        $this->is_admin_login();

        $cateList = CateModel::all();

        $this->view->assign('title','分类管理');
        $this->view->assign('empty','<span style="color: red">没有分类</span>');
        $this->view->assign('cateList',$cateList);

        return $this->view->fetch('cateList');
    }
    //编辑分类
    public function cateEdit(){
        $cataId = Request::param('id');

        $cataInfo = CateModel::where('id',$cataId)->find();

        $this->view->assign('title','编辑分类');
        $this->view->assign('cateInfo',$cataInfo);

        return $this->view->fetch('cateEdit');
    }

    public function doEdit(){
        //获取提交的信息
        $data = Request::param();

        //验证


            $id = $data['id'];

            unset($data['id']);

            if (CateModel::where('id',$id)->data($data)->update()){
                return $this->success('更新成功','cateList');
            }else{
                return $this->error('更新失败');
            }

    }

    public function doDelete(){
        //获取要删除的主键ID
        $id = Request::param('id');

        if (CateModel::where('id',$id)->delete()){
            return $this->success('删除成功','cateList');
        }
        return $this->error('删除失败');
    }

    public function cateAdd(){
        return $this->fetch('cateAdd',['title'=>'添加分类']);
    }

    public function doAdd(){
        $data = Request::param();

        if (CateModel::create($data)){
            return $this->success('添加成功','cateList');
        }
        return  $this->error('添加失败');
    }
}