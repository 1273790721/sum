<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class User extends Controller
{
    /*
     * @cuthor liuqin
     * function 用户管理
     */
    public function index(){
        $user = Db::connect('admin_db')->name('user')->paginate(10);
        $this->assign('users',$user);
        return $this->fetch();
    }
    
    /**
	* @author liuqin
     * function 添加用户
	*/
	public function add()
	{
		if(Request::instance()->isPost()){
            $_POST['password'] = md5($_POST['password']);
            $result = Db::connect('admin_db')->name('user')->insert($_POST);
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
            if(!empty($_POST['password'])){
                $_POST['password'] = md5($_POST['password']);
            }else{
                unset($_POST['password']);
            }
			$result = Db::connect('admin_db')->name('user')->update($_POST);
			if($result !== false){
				echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit;
			}else{
				echo json_encode(array('code'=>0,'msg'=>'修改失败'));exit;
			}
		}else{
			$id = input('get.id');
			$user = Db::connect('admin_db')->name('user')->find($id);
			$this->assign('user',$user);
			return $this->fetch();
		}
	}
    
	/**
	* @author liuqin
	*/
	public function userinfo()
	{
		if(Request::instance()->isPost()){
			$result = Db::connect('admin_db')->name('user')->update(input('post.'));
			if($result !== false){
				echo json_encode(['code'=>1,'msg'=>'修改成功']);exit;
			}else{
				echo json_encode(['code'=>0,'msg'=>'修改失败']);exit;
			}
		}else{
			$id = 1;
			$user = Db::connect('admin_db')->name('user')->find($id);
			$this->assign('user',$user);
			return $this->fetch();
		}
	}
    
    /**
	* @author liuqin
	*/
	public function del()
	{
		$id = input('post.id');
		$result = Db::connect('admin_db')->name('user')->delete($id);
		if($result){
			echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit;
		}else{
			echo json_encode(array('code'=>0,'msg'=>'删除失败'));exit;
		}
	}
    
    
}