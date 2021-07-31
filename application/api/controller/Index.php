<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Index extends controller
{	
	//注册
    public function zhuce()
    {  
        $post=$this->request->param();
        
        $bool=DB::name('user')->where('username',$post['username'])->find();

        if ($bool) {
            return 0;
        }else{
            $data=DB::name('user')->insert($post);
            if ($data) {
                return 1;
            }else{
                return 0;  
            }
        }
    }
    //登录
    public function login(){
        $post=$this->request->param();
        $bool=DB::name('user')->where('username',$post['username'])->find();

        if ($bool) {
            if ($bool['password']==$post['password']) {
                $data['msg']=1;
                $data['user']=$bool;
                return json($data);
            }else{
                $data['msg']=0;
                return json($data);
            }
        }else{
            $data['msg']=0;
            return json($data);
        }
    }
    //首页
    public function shop(){
        $data=DB::name('shop')->limit(10)->order('id desc')->select();

        return json($data);
    }
    //分类
    public function type(){
        $type_id=$this->request->param('id');

        if (!empty($type_id)) {
            $id=$type_id;
        }else{
            $id=1;
        }

        $type=DB::name('type')->select();

        $detail=DB::name('shop')->where('type_id',$id)->select();

        $data[type]=$type;
        $data[detail]=$detail;

        return json($data);
    }
    //详情
    public function detail(){
        $id=$this->request->param('id');

        $shop=DB::name('shop')->where('id',$id)->find();

        $data['id']=$shop['id'];
        $data['image']="http://localhost/diancan/public/static/".$shop['img'];
        $data['title']=$shop['name'];
        $data['price']=$shop['price'];
        $data['detail']=$shop['intro'];
        $data['parameter']=$shop['cs'];
        $data['service']=$shop['sh'];

        return json($data);
    }
    //加入购物车
    public function gwc(){
        $post=$this->request->param();

        $ins=[
            'sid'=>$post['id'],
            'num'=>$post['num'],
            'uid'=>$post['uid'],
            'time'=>date('Y-m-d H:i:s')
        ];

        $data=DB::name('shop_car')->insert($ins);


        if ($data) {
            return 1;
        }else{
            return 0;
        }

    }
    //购物车
    public function gwcList(){
        $id=$this->request->param('id');
        
        $shop=DB::name('shop_car')
        ->alias('a')
        ->join('shop s','a.sid = s.id')
        ->field('a.*,s.name,s.img,s.price')
        ->where('uid',$id)
        ->select();

        $data=[];
        foreach ($shop as $key => $value) {
            $data[$key]['id']=$value['id'];
            $data[$key]['title']=$value['name'];
            $data[$key]['image']="http://localhost/diancan/public/static/".$value['img'];
            $data[$key]['num']=$value['num'];
            $data[$key]['price']=$value['price'];
            $data[$key]['selected']="true";

        }
        return json($data);  
    }
    //购物车删除
    public function gwcDel(){
        $id=$this->request->param('id');

        $data=DB::name('shop_car')->where('id',$id)->delete();

        if ($data) {
            return 1;
        }else{
            return 0;
        }
    }
    //购物车管理
    public function js(){
        $post=$this->request->param();

        foreach ($post['carts'] as $key => $value) {
            if ($value['selected']=='true') {
                $ins['uid']=$post['uid'];
                $car=DB::name('shop_car')->where('id',$value['id'])->find();
                $ins['sid']=$car['sid'];
                $ins['num']=$value['num'];
                $ins['zj']=$value['price']*$value['num'];
                $ins['time']=time();

                $data=DB::name('order')->insert($ins);
                $bool=DB::name('shop_car')->where('id',$value['id'])->delete();

            }
        }

        return 1;
    }
    //订单管理
    public function order(){
        $id=$this->request->param('id');

        $order=DB::name('order')
        ->alias('a')
        ->join('shop s','a.sid = s.id')
        ->field('a.*,s.name,s.price,s.img')
        ->where('a.uid',$id)
        ->order('a.id desc')
        ->select();

        foreach ($order as $key => $value) {
            $data[$key]['number']=$value['id'];
            $data[$key]['thumb']="http://localhost/diancan/public/static/".$value['img'];
            $data[$key]['name']=$value['name'];
            $data[$key]['count']=$value['price'];
            $data[$key]['num']=$value['num'];
            $data[$key]['status']="已支付";
            $data[$key]['money']=$value['zj'];
        }

        return json($data);
    }
//餐桌管理
    public function canzhuo(){
        $data = DB::name('canzhuo')->order('id asc')->select();

        foreach ($data as $k =>$v){
            if($v['status']==0){
                $data[$k]['status']="未占用";
            }else{
                $data[$k]['status']="已占用";
            }
        }

        return json($data);
    }
    //预约订单
    public function yuyuedd(){
        $post = $this->request->param();

        $ins = [
            'yyname'=>$post['yyname'],
            'tel'=>$post['tel'],
            'canzhuo_id'=>$post['canzhuo_id'],
            'date'=>time(),
            'code'=>time()
        ];

        $data = DB::name('yuyue')->insert($ins);

        if($data){
            echo "预约成功";
        } else {
            echo '预约失败';
        }
    }
}
