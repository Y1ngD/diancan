<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Basic extends Controller
{
    public function _initialize()
    {	

        if(!session('user')){
            return $this->error('您没有登陆',url('Login/index'));
        }
    }
}
