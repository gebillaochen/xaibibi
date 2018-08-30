<?php
namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\ArtCate;
use app\common\model\Article;
use think\Db;
use think\facade\Request;//导入静态代理
class Index extends Base
{
    //首页
    public function index()
    {
        //全局查询条件
        $map = [];//将所有的查询条件都封装到这个数组中
        $map[] = ['status','=',1];
        //搜索功能
        $keywords = Request::param('keywords');
        if (!empty($keywords)){
            $map[] = ['title','like','%'.$keywords.'%'];
        }
        //分类信息显示
        $cateId = Request::param('cate_id');

        if (isset($cateId)){
            $res = ArtCate::get($cateId);
            $map[] = ['cate_id','=',$cateId];

            $artList = Db::table('gblc_article')
                ->where($map)
                ->order('create_time','desc')
                ->paginate(5);

            $this->view->assign('cateName',$res->name);
        }else{
            $this->view->assign('cateName','全部逼逼');
            $artList = Db::table('gblc_article')
                ->where($map)
                ->order('create_time','desc')
                ->paginate(5);
        }
        $this->view->assign('empty','<h3>没人这么逼逼</h3>');
        $this->view->assign('artList',$artList);
        return $this->fetch('index',['name'=>'瞎逼逼']);
    }
    //写入言论
    public function insert(){
        //检查是否登陆
        $this->Logined();
        //设置标题
        $this->view->assign('title','我要逼逼');
        //获取栏目信息
        $cateList = ArtCate::all();
        if (count($cateList)>0){
            //将查询到的栏目信息赋值给模板
            $this->assign('cateList',$cateList);
        }else{
            $this->error('请先添加栏目','index/index');
        }
        return $this->fetch();
    }

    //发布言论
    public function save(){
            if (Request::isPost()){
                //获取数据
                $data = Request::post();
                $res = $this->validate($data,'app\common\validate\Article');
                if (true !==$res){
                    //验证失败
                    echo '<script>alert("'.$res.'");location.back()</script>';
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

                    if (Article::create($data)){
                        $this->success('发布成功','index/index');
                    }else{
                        $this->error('发布失败');
                    }
                }
            }else{
                $this->error('请求类型错误','index/index');
            }
    }

    //详情页
    public function detail(){
        $artId = Request::param('id');
        $art = Article::get(function ($query) use ($artId){
           $query->where('id','=',$artId)->setInc('pv');
        });
        if (!is_null($art)){
            $this->view->assign('art',$art);
        }
        $this->view->assign('title','看他怎么逼逼');
        return $this->view->fetch('detail');
    }

    //收藏功能
    public function fav(){
        if (!Request::isAjax()){
            return ['status'=>-1,'message'=>'请求类型错误'];
        }
        //获取前端传递的数据
        $data = Request::param();
        //判断用户是否登陆
        if (empty($data['session_id'])){
            return ['status'=>-2,'message'=>'请先登录'];
        }
        //查询条件
        $map[] = ['user_id','=',$data['user_id']];
        $map[] = ['article_id','=',$data['article_id']];

        $fav = Db::table('gblc_user_fav')->where($map)->find();
        if (is_null($fav)){
            Db::table('gblc_user_fav')->data([
                'user_id'=>$data['user_id'],
                'article_id'=>$data['article_id'],
            ])->insert();
            return ['status'=>1,'message'=>'已收藏'];
        }else{
            Db::table('gblc_user_fav')->where($map)->delete();
            return ['status'=>0,'message'=>'点击收藏'];
        }
    }
}
