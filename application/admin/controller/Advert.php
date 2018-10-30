<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Advert extends Controller
{
    /*
     * @cuthor liuqin
     * function 广告管理
     */
    public function index(){
        $user = Db::connect('admin_db')->name('advert')->order('id desc')->paginate(10);
        $this->assign('users',$user);
        return $this->fetch();
    }
    
    /**
	* @author liuqin
     * function 添加权限
	*/
	public function add()
	{
	
		if(Request::instance()->isPost()){
			//var_dump($_POST);EXIT;
           // $_POST['password'] = md5($_POST['password']);
            $result = Db::connect('admin_db')->name('advert')->insert($_POST);
			//$result = Db::connect('admin_db')->name('user')->insert(input('post.'));
			if($result){
				echo json_encode(array('code'=>1,'msg'=>'添加成功'));exit;
			}else{
				echo json_encode(array('code'=>0,'msg'=>'添加失败'));exit;
			}
		}else{
			return $this->fetch();
		}
	}
    
    /**
	* @author liuqin
	*/
	public function edit()
	{
		if(Request::instance()->isPost()){
			//var_dump($_POST);EXIT;			
			$result = Db::connect('admin_db')->name('advert')->update($_POST);
			if($result !== false){
				echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit;
			}else{
				echo json_encode(array('code'=>0,'msg'=>'修改失败'));exit;
			}
		}else{
			$id = input('get.id');
			$user = Db::connect('admin_db')->name('advert')->find($id);
			$this->assign('user',$user);
			return $this->fetch();
		}
	}
	
	/**
	* @author liuqin
	*/
	public function del(){
         $ids = $_POST['id'];
         $model = Db::connect('admin_db')->name('advert');
            $model->where('id=' . $ids)->delete();
        echo json_encode(array(
            'code' => 1,
            'msg' => '删除成功', //'删除成功',
        ));
    }
	
	/*
     * @cuthor liuqin
     * function 角色管理
     */
    public function rule(){
        $user = Db::connect('admin_db')->name('advert')->order('id desc')->paginate(10);
        $this->assign('users',$user);
        return $this->fetch();
    }
	
	/**
	* @author liuqin
     * function 添加角色
	*/
	public function add_rule()
	{
	
		if(Request::instance()->isPost()){
            $result = Db::connect('admin_db')->name('auth_group')->insert($_POST);
			//$result = Db::connect('admin_db')->name('user')->insert(input('post.'));
			if($result){
				echo json_encode(array('code'=>1,'msg'=>'添加成功'));exit;
			}else{
				echo json_encode(array('code'=>0,'msg'=>'添加失败'));exit;
			}
		}else{
			return $this->fetch();
		}
	}
	
	/**
	 *@auth liuqin
     * 删除
     */
    public function delete_rule() {
        $model = Db::connect('admin_db')->name('auth_group');
        $ids = isset($_POST['id']) ? $_POST['id'] : '0';
        /*$count = M('user_admin','kt_','course_db')->where(array('role_id'=>$ids,'is_del'=>0))->count();
        if($count>0){
            echo json_encode(array(
                    'flag' => 0,
                    'msg' => '该角色已分配管理员，不能删除',
            ));die;
        }*/
        $model->where('id=' . $ids)->delete();
        echo json_encode(array(
            'code' => 1,
            'msg' => '删除成功', //'删除成功',
        ));
    }
	
	/**
	* @author liuqin
	* function 修改角色
	*/
	public function edit_rule()
	{
		if(Request::instance()->isPost()){
			$result = Db::connect('admin_db')->name('auth_group')->update($_POST);
			if($result !== false){
				echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit;
			}else{
				echo json_encode(array('code'=>0,'msg'=>'修改失败'));exit;
			}
		}else{
			$id = input('get.id');
			$user = Db::connect('admin_db')->name('auth_group')->find($id);
			$this->assign('user',$user);
			return $this->fetch();
		}
	}
    
	 /**
     * 缓存权限树
     * @return type
     */
    private function cacheAuthTree() {
        if (isset($_SESSION['allAuthtree'])) {
            return $_SESSION['allAuthtree'];
        }
        //构造成功能树，供权限设置界面调用

        $model = Db::connect('admin_db')->name('auth_rule');//M('auth_rule','kt_','course_db');
        //$itemmodel = M('auth_rule');
        $dataservice = array( array('id' => 'root2', 'text' => '管理功能', 'group' => 'admin'));
        //查询子分类项目
        for ($index = 0; $index < count($dataservice); $index++) {
            $cateid = $dataservice[$index]['group'];
            $map['group'] = $cateid;
            $map['pid'] = 0;
            //$map['type'] = 1;
            $funcs = array();
            $firtstdata = $model->where($map)->field('id,title as text')->order('sortorder asc,id asc')->select();
            for ($j = 0; $j < count($firtstdata); $j++) {
                $pdata = $firtstdata[$j];
                $this->getChildTreeNode($firtstdata[$j]['id'], $pdata);
                $funcs[] = $pdata;
            }
            if ($firtstdata && count($firtstdata) > 0) {
                $dataservice[$index]['children'] = $funcs;
            }
        }

        $_SESSION['allAuthtree'] = $dataservice;
        return $dataservice;
    }

    public function readAuthTree() {
        echo json_encode($this->cacheAuthTree());
    }

    public function editAuthTree() {
        header("Content-Type:text/html;charset=UTF-8");
        //获取角色权限
        $id = $_GET['id'];
        $model = Db::connect('admin_db')->name('auth_group');//M('auth_group','kt_','course_db');
        $data = $model->where('id=' . $id)->find();
        $checkedis = explode(',', $data['rules']);
        if (empty($checkedis)) {
            $checkedis = array();
        }
        $authTree = $this->cacheAuthTree();
        $funcs = array();
        //遍历数据子节点，设置选中
        for ($index = 0; $index < count($authTree); $index++) {
            $data = $authTree[$index];
            if (in_array($data['id'], $checkedis)) {
                //设置选中
                $data['state'] = array("selected" => true);
            }
            //遍历子节点，设置选中
            if (count($data['children']) > 0) {
                $checkparent = self::checkChildTreeNode($data, $data['children'], $checkedis);
                if (!$checkparent) {
                    $data['state'] = '';
                }
            }
            $funcs[] = $data;
        }
      //  var_dump($funcs);exit;
        echo json_encode($funcs);
    }

    private function checkChildTreeNode(&$pnode, &$pdata, $checkedis) {
        $checkparent = true;
        for ($index = 0; $index < count($pdata); $index++) {
            $data = $pdata[$index];
            if (in_array($data['id'], $checkedis)) {
                //设置选中
                $pdata[$index]['state'] = array("selected" => true);
            } else {
                $pnode['state'] = '';
                $checkparent = false;
            }
            //遍历子节点，设置选中
            if (count($pdata[$index]['children']) > 0) {
                $checkparent = self::checkChildTreeNode($pdata[$index], $pdata[$index]['children'], $checkedis);
            }
            if (!$checkparent) {
                $pnode['state'] = '';
            }
        }
        return $checkparent;
    }

    /**
     * 获取子功能节点
     * @param type $pid
     */
    private function getChildTreeNode($pid, &$pdata) {
        $authmodel = Db::connect('admin_db')->name('auth_rule');//M('auth_rule','kt_','course_db');
        $map['pid'] = $pid;
        $map['status'] = 1; //启用状态
        //先读取所有，权限生效，加上id  in（1,2,3）
        $dataauth = $authmodel->where($map)->field('id,title as text')->order('sortorder asc,id asc')->select();
        $funcs = array();
        for ($index = 0; $index < count($dataauth); $index++) {
            //给每个功能设置一个键
            $data = $dataauth[$index];

            //查找子功能
            $parent = $data['id'];
            $this->getChildTreeNode($parent, $data);
            $funcs[] = $data;
        }
        $pdata['children'] = $funcs;
    }
    
     //显示图标页面
    public function icons(){
        return $this->fetch();
    }
    //获取数据库权限相关信息
     public function getAuthCategory() {
        //查询服务表
		//echo 1;
        $model = Db::connect('admin_db')->name('auth_rule');//M('auth_rule','kt_','course_db');
		//echo 2;
		//echo 2;
        $dataservice = array( array('v'=>'admin', 'n' => '公司'));
        //查询子分类项目
        for ($index = 0; $index < count($dataservice); $index++) {
            $cateid = $dataservice[$index]['v'];
             $map['group'] = $cateid;
            $role = $model->where($map)->select();
            $data = $this->sortOut($role);

            /* if ($data && count($data) > 0) {
                $dataservice[$index]['s'] = $data;
            } */
        }
        echo json_encode($data);
    }

    public function sortOut($cate, $pid = 0, $level = 0, $html = '--') {
        $tree = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['n'] = str_repeat($html, $level) . $v['title'];
                $v['v'] = $v['id'];
                $tree[] = $v;
                $tree = array_merge($tree, self::sortOut($cate, $v['id'], $level + 1, $html));
            }
        }
        return $tree;
    }
    
    
    
}