<?php
/**
 * 用户注册管理
 */

namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

class User extends Base
{
    //用户注册
    public function register(){
        $this->isLogin();
        $this->is_reg();
        $this->assign("title","用户注册");
        return $this->fetch();
    }

    //处理用户请求的注册信息
    public function insert(){
        $this->is_reg();
        if (Request::isAjax()){
            //验证数据
            $data = Request::post();
            $rule = 'app\common\validate\User';
            //开始验证
            $res = $this->validate($data,$rule);
            if (true !==$res){//false
                return ['status'=>-1,'message'=>$res];
            }else{
                if ($user = UserModel::create($data)){
                    $res = UserModel::get($user->id);
                    Session::set('user_id',$res->id);
                    Session::set('user_name',$res->name);
                    Session::set('is_admin',$result['is_admin']);
                    return ['status'=>1,'message'=>'恭喜，注册成功'];
                }else{
                    return ['status'=>0,'message'=>'注册失败'];
                }
            }
        }else{
            $this->error('数据错误','register');
      }
    }

    //用户登陆
    public function login(){
        $this->isLogin();
        return $this->view->fetch('login',['title'=>'用户登陆']);
    }

    //登陆验证
    public function loginCheck(){
        $this->isLogin();
        if (Request::isAjax()){
            //验证数据
            $data = Request::post();
            $rule = [
                'email|邮箱'=>'require|email',
                'password|密码'=>'require|length:6,20|chsAlphaNum',
            ];
            //开始验证
            $res = $this->validate($data,$rule);
            if (true !==$res){//false
                return ['status'=>-1,'message'=>$res];
            }else{
                //执行查询
                $result = UserModel::get(function ($query) use ($data){
                    $query->where('email',$data['email'])
                        ->where('password',sha1($data['password'])
                        );
                });
                if (null==$result){
                    return ['status'=>0,'message'=>',邮箱或密码不正确'];

                }else{
                    //将用户的数据写到Session
                    Session::set('user_id',$result->id);
                    Session::set('user_name',$result->name);
                    return ['status'=>1,'message'=>'正在跳转！'];

                }
            }
        }else{
            $this->error('数据错误','login');
        }
    }

    //退出登陆
    public function logout(){
        //Session::delete('user_id');
        //Session::delete('user_name');
        Session::clear();
        $this->success('退出成功','index/index');
    }
}