<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27 0027
 * Time: 下午 2:03
 */

namespace app\admin\controller;

use app\admin\common\controller\Base;
use app\admin\common\model\Cate as CateModel;
use app\admin\common\model\Article as ArticleModel;
use think\facade\Request;
use think\facade\Session;
class Article extends Base
{
    public function index(){
        $this->Logined();
        return $this->redirect('ArticleList');
    }

    public function ArticleList(){
        $this->Logined();

        $userId = Session::get('user_id');
        $isAdmin = Session::get('is_admin');

        $artList = ArticleModel::where('user_id',$userId)->paginate(5);
        if ($isAdmin==1){
            $artList = ArticleModel::paginate(5);
        }

        $this->view->assign('title','逼逼管理');
        $this->view->assign('empty','<span style="color: red">没有逼逼</span>');
        $this->view->assign('ArticleList',$artList);

        return $this->view->fetch('articleList');
    }
    //编辑分类
    public function artEdit(){
        $artId = Request::param('id');

        $artInfo = ArticleModel::where('id',$artId)->find();

        $cateList = CateModel::all();
        $this->view->assign('title','编辑分类');
        $this->view->assign('artInfo',$artInfo);
        $this->view->assign('cateList',$cateList);

        return $this->view->fetch('artEdit');
    }

    public function doEdit(){
        if (Request::isPost()){
            //获取数据
            $data = Request::post();
            $res = $this->validate($data,'app\common\validate\Article');
            if (true !==$res){
                //验证失败
                echo '<script>alert("'.$res.'");window.location.back()</script>';
            }else{
                //获取图片
                $file = Request::file('title_img');
                //文件验证成功后上传到服务器的指定目录
                $info =  $file->validate([
                    'size'=>1000000,
                    'ext'=>'jpeg,jpg,png,gif',

                ])->move('uploads');
                if ($info){
                    $data['title_img'] = $info->getSaveName();
                }else{
                    $this->error($file->getError());
                }

                if (ArticleModel::update($data)){
                    $this->success('修改成功','ArticleList');
                }else{
                    $this->error('修改失败');
                }
            }
        }else{
            $this->error('请求类型错误');
        }
    }

    public function doDelete(){
        //获取要删除的主键ID
        $id = Request::param('id');
        if (ArticleModel::destroy($id)){
            return $this->success('删除成功','ArticleList');
        }
        return $this->error('删除失败');
    }
}