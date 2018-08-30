<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 下午 5:07
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

class User extends Base
{
    //渲染登陆界面
    public function login(){
        $this->isLogin();
        $this->view->assign('title','管理员登陆');
        return $this->view->fetch("login");
    }

    //验证后台登陆
    public function checkLogin(){
        $this->isLogin();
        $data = Request::param();

        $map[] = ['email','=',$data['email']];
        $map[] = ['password','=',sha1($data['password'])];

        $result = UserModel::where($map)->find();
        if ($result){
                Session::set('user_id',$result['id']);
                Session::set('user_name',$result['name']);
                Session::set('is_admin',$result['is_admin']);
                $this->success('登陆成功','admin/user/userList');
        }
        $this->error('登陆失败');
    }

    //退出登陆
    public function logout(){
        Session::clear();
        $this->success('退出成功','admin/user/login');
    }

    public function userList(){
        $this->Logined();
        $data['user_id']=Session::get('user_id');
        $data['is_admin']=Session::get('is_admin');

        $userList = UserModel::where('id',$data['user_id'])->select();

        if ($data['is_admin']==1){
            $userList = UserModel::select();
        }

        $this->view->assign('title','用户管理');
        $this->view->assign('empty','<span style="color: red">没有任何数据</span>');
        $this->view->assign('userList',$userList);

        return $this->view->fetch('userList');
    }

    //渲染编辑界面
    public function userEdit(){
        $this->Logined();
        //获取用户的主键
        $id = Session::get('user_id');
        //进行查询
        $userInfo = UserModel::where('id',$id)->find();

        //编码模板变量
        $this->view->assign('title','编辑用户');
        $this->view->assign('userInfo',$userInfo);

        //渲染界面
        return $this->view->fetch('userEdit');
    }

    //执行用户信息的保存
    public function doEdit(){

        //获取提交的信息
        $data = Request::param();
        $id = Session::get('user_id');
        //验证
        $rule = 'app\admin\common\validate\User';
        $res = $this->validate($data,$rule);
            if (true !==$res){//false
                return $this->error($res);
            }else{
                $data['password'] = sha1($data['password']);
                unset($data['password_confirm']);
                if ($user = UserModel::where('id',$id)->data($data)->update()){
                    return $this->success('更新成功','userList');
                }else{
                    return $this->error('更新失败');
                }
            }
    }

    //执行用户删除操作
    public function doDelete(){
        $this->is_admin_login();
        //获取要删除的主键ID
        $id = Request::param('id');

        if (UserModel::where('id',$id)->delete()){
            return $this->success('删除成功','userList');
        }
        return $this->error('删除失败');
    }
}