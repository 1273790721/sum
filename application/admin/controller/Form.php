<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Form extends Controller
{
	/**
	* @author liuqin
	*/
    public function submit()
    {
    	if(Request::instance()->isPost()){
    		$result = db('submit','admin_db')->insert(input('post.'));
    		if($result){
    			echo json_encode(array('code'=>1,'msg'=>'提交成功'));exit;
    		}else{
    			echo json_encode(array('code'=>0,'msg'=>'提交失败'));exit;
    		}
    	}else{
        	return $this->fetch();
    	}
    }
    /**
	* @author liuqin
	*/
    public function submitone()
    {
        return $this->fetch();
    }
    /**
	* @author liuqin
	*/
    public function submittwo()
    {
    	if(Request::instance()->isPost()){
    		$db = Db::connect('admin_db');
    		$data['name'] = input('post.name');
    		$data['sex'] = input('post.sex');
    		$data['age'] = input('post.age');
    		$data['mark'] = input('post.mark');
            $db->startTrans();
            try{
        		$result1 = $db->name('submit')->insertGetId($data);
        		$app['sid'] = $result1;
        		$app['username'] = input('post.username');
        		$app['password'] = input('post.password');
        		$result2 = $db->name('submit_append')->insertGetId($app);
                $db->commit();
                echo json_encode(array('code'=>1,'msg'=>'提交成功'));exit;
            }catch(\Exception $e){
                $db->rollback();
                echo json_encode(array('code'=>0,'msg'=>'提交失败'));exit;
            }
    	}else{
        	return $this->fetch();
    	}
    }
}
