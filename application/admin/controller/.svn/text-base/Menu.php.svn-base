<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Menu extends Controller
{
    /**
    * @author liuqin
    * @function 菜单
    * @time 2017-04-18
    */
	public function index(){
		$list = Db::connect('admin_db')->name('menus')->where(array('pid'=>1))->select();
        $this->assign('list',$list);
        return $this->fetch();
	}
    /**
    * @author liuqin
    * @function 添加
    * @time 2017-04-18
    */
	public function add(){
    	if(!empty($_POST)){
    		$result = Db::connect('admin_db')->name('menus')->insert($_POST);
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
    * @function 修改
    * @time 2017-04-18
    */
    public function edit(){
    	if(!empty($_POST)){
            if($_POST['id'] == $_POST['pid']){
                echo json_encode(array('code'=>0,'msg'=>'不能选择自身作为父级权限'));exit;
            }
    		$result = Db::connect('admin_db')->name('menus')->update($_POST);
    		if($result){
    			echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit;
    		}else{
    			echo json_encode(array('code'=>0,'msg'=>'修改失败'));exit;
    		}
    	}else{
            $id = $_GET['id'];
    		$rule = Db::connect('admin_db')->name('menus')->where(array('id'=>$id))->find();//D('Rule')->get_rule($id);
            $this->assign('rule',$rule);
    		return $this->fetch();
    	}
    }
	
	/**
	* @author liuqin
	*/
	public function del()
	{
		$id['id'] = $_POST['id'];
		$result = Db::connect('admin_db')->name('menus')->where($id)->delete();
		if($result){
			echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit;
		}else{
			echo json_encode(array('code'=>0,'msg'=>'删除失败'));exit;
		}
	}
	
	//获取数据库权限相关信息
     public function getAuthCategory() {
        //查询服务表
		//echo 1;
        $model = Db::connect('admin_db')->name('menus');//M('auth_rule','kt_','course_db');
		//echo 2;
		//echo 2;
        $dataservice = array( array('v'=>'admin', 'n' => '公司'));
        //查询子分类项目
        for ($index = 0; $index < count($dataservice); $index++) {
            $cateid = $dataservice[$index]['v'];
             $map['status'] = 1;
            $role = $model->where($map)->select();
			//var_dump($role);
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
                $v['n'] = str_repeat($html, $level) . $v['menu'];
                $v['v'] = $v['id'];
                $tree[] = $v;
                $tree = array_merge($tree, self::sortOut($cate, $v['id'], $level + 1, $html));
            }
        }
        return $tree;
    }
	
	/**
	* @author liuqin
	*/
	public function ajax_tree()
	{
		$list = Db::connect('admin_db')->name('menus')->where(array('pid'=>0))->order('sortorder asc')->select();
		$i=0;
		foreach($list as $k=>$v){
			$i++;
			$list[$k]['i'] = $i;
			$list[$k]['tree_name'] = $v['menu'];
			$jie = Db::connect('admin_db')->name('menus')->where(array('pid'=>$v['id']))->order('sortorder asc')->select();
			foreach($jie as $ks=>$vs){
				$i++;
				$jie[$ks]['i'] = $i;
				$jie[$ks]['tree_name'] = $vs['menu'];
			}
			$list[$k]['children'] = $jie;
		}
		echo json_encode($list);
	}

}