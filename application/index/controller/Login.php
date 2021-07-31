<?php
 
namespace app\index\controller;
 
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
class Login extends Controller{
    public function index(){
        return $this->fetch();
    }
    public function login(){

        //判断是否是post方法发送的数据：如果是则开始登陆
        if (Request::instance()->isPost()){
            //表单提交过来的验证码验证
            $code = input('code');

            if (!captcha_check($code)){
                $this->error("验证码错误",'login/index');
            }

            $username = $this->request->param('username');//接收前台用户名
            $password = $this->request->param('password');//接收前台密码
            
            if(empty($username) || empty($password)){
 
                $this->error("用户名或者密码不能为空！");
            }
            //从数据库读取数据
            $admin_info = DB::name('admin')
            ->where('username',$username)
            ->find(); 
            if(empty($admin_info)){
                $this->error('用户不存在，请重新登陆',url('Login/login'));
            }else{
                if($password!=$admin_info['password']){
 
                    $this->error('密码不正确，请重新登陆',url('Login/login'));
                }else{
                    Session::set('user',$admin_info);
                    $this->success("登录成功！",url('Index/index'));
                }
            }
           
        }else{//如果不是post，则返回登陆界面
            return view('login/index');
        }
    }
    public function logout(){
        session(null);//退出清空session
        return $this->success('退出成功',url('Login/index'));//跳转到登录页面
    }
    //注册
    public function zhuce(){


        return $this->fetch();
    }
    public function zhuceUp(){

        $post=$this->request->param();

        if ($post['password']!=$post['repassword']) {
            $this->error('两次输入的密码不一致');
        }

        $user=DB::name('user')->where('username',$post['username'])->find();


        if ($user) {
            $this->error('用户名已存在');
        }

        $ins=[
            'username'=>$post['username'],
            'password'=>$post['password']            
        ];
        $data=Db::name('user')->insert($ins);

        if ($data) {
            $this->success('注册成功','login/index');
        }else{
            $this->error('注册失败');
        }
    }
}
