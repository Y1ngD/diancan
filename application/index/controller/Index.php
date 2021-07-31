<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\View;
use think\Db;

class Index extends Basic
{	
	//首页
    public function index()
    {  
    	return $this->fetch();
    }
    public function home(){

    	return $this->fetch();
    }

    // 管理员管理
    public function gly(){
        $list=DB::name('admin')->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //添加管理员
    public function glyAdd(){
        return $this->fetch();
    }
    public function glyAddup(){
        $ins=$this->request->param();

        $bool=DB::name('admin')->insert($ins);

        if ($bool) {
            $this->success('添加成功','index/gly');
        }else{
            $this->error('添加失败');
        }
    }
    //管理员修改
    public function glyEdit(){
        $id=$this->request->param('id');

        $data=DB::name('admin')->where('id',$id)->find();

        $this->assign('data',$data);
        return $this->fetch();
    }
    public function glyEditup(){
        $post=$this->request->param();

        $data=DB::name('admin')->where('id',$post['id'])->update(['username'=>$post['username'],'password'=>$post['password']]);

        if ($data) {
            $this->success('修改成功','index/gly');
        }else{
            $this->error('未做任何修改！');
        }
    }
    //管理员删除
    public function glyDel(){
        $id=$this->request->param('id');
        $bool=DB::name('admin')->where('id',$id)->delete();

        if ($bool) {
            $this->success('删除成功','index/gly');
        }else{
            $this->error('删除失败');
        }
    }


    //用户管理
    public function user(){
    	$list=DB::name('user')->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //添加用户
    public function userAdd(){
        return $this->fetch();
    }
    public function userAddup(){
        $ins=$this->request->param();

        $bool=DB::name('user')->insert($ins);

        if ($bool) {
            $this->success('添加成功','index/user');
        }else{
            $this->error('添加失败');
        }
    }
    //用户修改
    public function userEdit(){
        $id=$this->request->param('id');

        $data=DB::name('user')->where('id',$id)->find();

        $this->assign('data',$data);
        return $this->fetch();
    }
    public function userEditup(){
        $post=$this->request->param();

        $data=DB::name('user')->where('id',$post['id'])->update(['username'=>$post['username'],'password'=>$post['password']]);

        if ($data) {
            $this->success('修改成功','index/user');
        }else{
            $this->error('未做任何修改！');
        }
    }
    //用户删除
    public function userDel(){
        $id=$this->request->param('id');
        $bool=DB::name('user')->where('id',$id)->delete();

        if ($bool) {
            $this->success('删除成功','index/user');
        }else{
            $this->error('删除失败');
        }
    }

    //分类管理
    public function type(){
        $list=DB::name('type')->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //添加分类
    public function typeAdd(){
        return $this->fetch();
    }
    public function typeAddup(){
        $ins=$this->request->param();

        $bool=DB::name('type')->insert($ins);

        if ($bool) {
            $this->success('添加成功','index/type');
        }else{
            $this->error('添加失败');
        }
    }
    //分类修改
    public function typeEdit(){
        $id=$this->request->param('id');

        $data=DB::name('type')->where('id',$id)->find();

        $this->assign('data',$data);
        return $this->fetch();
    }
    public function typeEditup(){
        $post=$this->request->param();

        $data=DB::name('type')->where('id',$post['id'])->update(['type'=>$post['type']]);

        if ($data) {
            $this->success('修改成功','index/type');
        }else{
            $this->error('未做任何修改！');
        }
    }
    //分类删除
    public function typeDel(){
        $id=$this->request->param('id');
        $bool=DB::name('type')->where('id',$id)->delete();

        if ($bool) {
            $this->success('删除成功',index/type);
        }else{
            $this->error('删除失败');
        }
    }


    //餐品管理
    public function cpList(){
        $list=DB::name('shop')
        ->alias('a')
        ->join('type t','a.type_id = t.id')
        ->field('a.*,t.type')
        ->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //餐品新增
    public function cpAdd(){
        $data=DB::name('type')->select();

        $this->assign('data',$data);
        return $this->fetch();
    }
    public function cpAddup(){
        $post=$this->request->param();
        //图片上传
        $file =request()->file("img");
         if (empty($file)) {
            $this->error('请选择上传图片');
        }
        $arr = $file->getInfo(); // 文件名称
        $config = array('size' => 1024 * 1024 * 10, 'ext' => array('jpg', 'jpeg', 'png', 'gif'));
        $ext = strrchr($arr['name'], "."); //扩展名，带"."
        $filename = date("YmdHis") . "" . $ext;
        $info = $file->validate($config)
                    ->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images', $filename);
        $fileUrl = 'images/'.$filename; 
        if ($info) {
            $ins=[
                'type_id'=>$post['type_id'],
                'name'=>$post['name'],
                'intro'=>$post['intro'],
                'price'=>$post['price'],
                'cs'=>$post['cs'],
                'sh'=>$post['sh'],
                'img'=>$fileUrl
            ];
            $data=DB::name('shop')->insert($ins);

            if ($data) {
                $this->success('添加成功','index/cpList');
            }else{
                $this->error('添加失败');
            }

        }else{
            $this->error('图片上传失败');
        }

    }
    //餐品修改
    public function cpEdit(){
        $id=$this->request->param('id');

        $type=DB::name('type')->select();
        $data=DB::name('shop')->where('id',$id)->find();

        $this->assign('type',$type);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function cpEditup(){
        $post=$this->request->param();

        //图片上传
        $file =request()->file("img");
        if (empty($file)) {
            $ins=[
                'type_id'=>$post['type_id'],
                'name'=>$post['name'],
                'intro'=>$post['intro'],
                'price'=>$post['price'],
                'cs'=>$post['cs'],
                'sh'=>$post['sh'],
            ];
            $id=$post['id'];
            $data=DB::name('shop')->where('id',$id)->update($ins);
            
            if ($data) {
                $this->success('修改成功','index/cpList');
            }else{
                $this->error('未做任何修改！');
            }
        }else{
            $arr = $file->getInfo(); // 文件名称
            $config = array('size' => 1024 * 1024 * 10, 'ext' => array('jpg', 'jpeg', 'png', 'gif'));
            $ext = strrchr($arr['name'], "."); //扩展名，带"."
            $filename = date("YmdHis") . "" . $ext;
            $info = $file->validate($config)
                        ->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images', $filename);
            $fileUrl = 'images/'.$filename; 
            if ($info) {
                $ins=[
                    'type_id'=>$post['type_id'],
                    'name'=>$post['name'],
                    'intro'=>$post['intro'],
                    'price'=>$post['price'],
                    'cs'=>$post['cs'],
                    'sh'=>$post['sh'],
                    'img'=>$fileUrl
                ];

                $id=$post['id'];
                $data=DB::name('shop')->where('id',$id)->update($ins);

                if ($data) {
                    $this->success('修改成功','index/cpList');
                }else{
                    $this->error('未做任何修改！');
                }
            }else{
                    $this->error('图片上传失败');
            }
        }
        
    }
    //餐品删除
    public function cpDel(){
        $id=$this->request->param('id');

        $bool=DB::name('shop')->where('id',$id)->delete();

        if ($bool) {
            $this->success('删除成功','index/cpList');
        }else{
            $this->error('删除失败');
        }
    }
    //订单管理
    public function dd(){
        $time = $this->request->param('time');
        if(!empty($time)){
            $where['a.time']=['like',"%".$time."%"];
            $this->assign('time',$time);
        }
        $list=DB::name('order')
        ->alias('a')
        ->join('shop s','a.sid = s.id')
        ->join('user u','a.uid = u.id')
        ->join('type t','s.type_id = t.id')
        ->field('a.*,s.name,s.price,s.img,u.username,t.type')
        ->order('a.id desc')
        ->paginate(5);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //订单删除
    public function ddDel(){
        $id=$this->request->param('id');

        $bool=DB::name('order')->where('id',$id)->delete();

        if ($bool) {
            $this->success('删除成功','index/dd');
        }else{
            $this->error('删除失败');
        }
    }
    //餐桌管理
    public function canzhuo(){
        $list=DB::name('canzhuo')
        ->order('id desc')
        ->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //餐桌新增
    public function canzhuoAdd(){
        return $this->fetch();
    }
    public function canzhuoAddup(){
        $post = $this->request->param();

        $data = DB::name('canzhuo')->insert($post);

        if($data){
            $this->success("添加成功",'index/canzhuo');
        }else{
            $this->error("添加失败");
        }
    }
    //餐桌修改
    public function canzhuoEdit(){
        $id = $this->request->param('id');

        $data = DB::name('canzhuo')->where('id',$id)->find();

        $this->assign('data',$data);
        return $this->fetch(); 
    }
    public function canzhuoEditup(){
        $post= $this->request->param();

        $up=[
            'name'=>$post['name'],
            'num'=>$post['num']
        ];

        $data = DB::name('canzhuo')->where('id',$post['id'])->update($up);

        if($data){
            $this->success("修改成功",'index/canzhuo');
        }else{
            $this->error('未做任何修改！');
        }
    }
    //餐桌删除
    public function canzhuoDel(){
        $id = $this->request->param('id');

        $data = DB::name('canzhuo')->where('id',$id)->delete();

        if($data){
            $this->success("删除成功",'index/canzhuo');
        }else{
            $this->error('删除失败');
        }
    }
    //预约管理
    public function yuyue(){
        $yyname = $this->request->param('yyname');
        $code = $this->request->param('code');

        if(!empty($yyname)){
            $where['a.yyname']=['like',"%".$yyname."%"];
            $this->assign('yyname',$yyname);
        }
        if(!empty($code)){
            $where['a.code']=['like',"%".$code."%"];
            $this->assign('code',$code);
        }

        $list = DB::name('yuyue')
        ->alias('a')
        ->join('canzhuo c','a.canzhuo_id = c.id')
        ->field('a.*,c.name,c.num')
        ->order('a.id desc')
        ->where($where)
        ->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
    //预约订单处理
    public function ddcl(){
        $post = $this->request->param();

        $data = DB::name('yuyue')->where('id',$post['id'])->update(['status'=>$post['status']]);

        $canzhuo = DB::name('yuyue')->where('id',$post['id'])->find();
        if($post['status']==1){
            DB::name('canzhuo')->where('id',$canzhuo['canzhuo_id'])->update(['status'=>1]);
        }else{
            DB::name('canzhuo')->where('id',$canzhuo['canzhuo_id'])->update(['status'=>0]);
        }

        if($data){
            $this->success("处理成功",'index/yuyue');
        }else{
            $this->error('处理失败');
        }
    }
    //预约修改
    public function yuyueEdit(){
        $id = $this->request->param('id');

        $canzhuo = DB::name('canzhuo')->select();


        $data = DB::name('yuyue')->where('id',$id)->find();

        $this->assign('canzhuo',$canzhuo);
        $this->assign('data',$data);
        return $this->fetch();
    }
    //修改上传
    public function yuyueEditup(){
        $post = $this->request->param();

        $time = strtotime($post['date']);

        $up=[
            'canzhuo_id'=>$post['canzhuo_id'],
            'date'=>$time,
            'status'=>0
        ];
        $data = DB::name('yuyue')->where('id',$post['id'])->update($up);

        $canzhuo = DB::name('yuyue')->where('id',$post['id'])->find();
        DB::name('canzhuo')->where('id',$canzhuo['canzhuo_id'])->update(['status'=>0]);
        if($data){
            $this->success("修改成功",'index/yuyue');
        }else{
            $this->error('未做任何修改！');
        }
    }
    //预约删除
    public function yuyueDel(){
        $id = $this->request->param('id');

        $canzhuo = DB::name('yuyue')->where('id',$id)->find();
        DB::name('canzhuo')->where('id',$canzhuo['canzhuo_id'])->update(['status'=>0]);

        $data = DB::name('yuyue')->where('id',$id)->delete();

        if($data){
            $this->success("删除成功",'index/yuyue');
        }else{
            $this->error('删除失败');
        }
    }
    //统计图表
    public function tongji(){

        return $this->fetch();
    }
    public function tj(){
        $date = $this->request->param('date');

        $date2 = $date;
        if(empty($date)){
            $y = date('Y');
            $m = date('m');
            $d = date('d');
            $date = date("Y-m-d"); 
        }else{
            $y = date('Y',strtotime($date));
            $m = date('m',strtotime($date));
            $d = date('d',strtotime($date));
        }

        for ($i=0; $i < 24; $i++) {
            if($i%2==0){
                $start = $y.'-'.$m.'-'.$d.' '.$i.':00';
                $time[$i]['start'] = strtotime($start);
                $k =$i+1;
                $end = $y.'-'.$m.'-'.$d.' '.$k.':59';
                $time[$i]['end'] = strtotime($end);
            } 
            
        }
        
        $time = array_values($time);

        $type = DB::name('type')->select();
        foreach ($type as $k => $v){
            $legend[$k] = $v['type'];
            $series[$k]['name'] = $v['type'];
            $series[$k]['type'] = 'line';
            $series[$k]['stack'] = '销量';

            for ($j=0; $j < 12; $j++) { 
                $series[$k]['data'][$j]=DB::name('order')
                ->alias('a')
                ->join('shop s','a.sid = s.id')
                ->where('s.type_id',$v['id'])
                ->where('a.time','>',$time[$j]['start'])
                ->where('a.time','<',$time[$j]['end'])
                ->sum('num');
            }

        }
        
        $data['date'] = $date2;
        $data['title'] = $date;
        $data['legend'] = $legend;
        $data['series'] = $series;

        return json($data);
    }
    public function tj2(){
        $date = $this->request->param('date');

        $date2 =$date;
        if(empty($date)){
            $y = date('Y');
            $m = date('m');
            $d = date('d');
            $date = date("Y-m-d"); 
        }else{
            $y = date('Y',strtotime($date));
            $m = date('m',strtotime($date));
            $d = date('d',strtotime($date));
        }

        for ($i=0; $i < 24; $i++) {
            if($i%2==0){
                $start = $y.'-'.$m.'-'.$d.' '.$i.':00';
                $time[$i]['start'] = strtotime($start);
                $k =$i+1;
                $end = $y.'-'.$m.'-'.$d.' '.$k.':59';
                $time[$i]['end'] = strtotime($end);
            } 
            
        }
        
        $time = array_values($time);

        $type = DB::name('type')->select();
        foreach ($type as $k => $v){
            $legend[$k] = $v['type'];
            $series[$k]['name'] = $v['type'];
            $series[$k]['type'] = 'line';
            $series[$k]['stack'] = '销量';

            for ($j=0; $j < 12; $j++) { 
                $series[$k]['data'][$j]=DB::name('order')
                ->alias('a')
                ->join('shop s','a.sid = s.id')
                ->where('s.type_id',$v['id'])
                ->where('a.time','>',$time[$j]['start'])
                ->where('a.time','<',$time[$j]['end'])
                ->sum('zj');
            }

        }
        
        $data['date'] = $date2;
        $data['title'] = $date;
        $data['legend'] = $legend;
        $data['series'] = $series;

        return json($data);
    }
}
