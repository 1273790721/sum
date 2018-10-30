<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Index extends Controller
{
  /*
  * @author liuqin
  * @time 2017-04-14
  * @name  清除缓存
  */
/*public function deltree($pathdir)
    {
        $pathdir = input('post.dir');
        if($this->is_empty_dir($pathdir)){//如果是空的
            rmdir($pathdir);//直接删除
        }else{//否则读这个目录，除了.和..外
              $d=dir($pathdir);
              while($a=$d->read())
              {
                  if(is_file($pathdir.'/'.$a) && ($a!='.') && ($a!='..')){unlink($pathdir.'/'.$a);}
                  //如果是文件就直接删除
                  if(is_dir($pathdir.'/'.$a) && ($a!='.') && ($a!='..'))
                  {//如果是目录
                      if(!$this->is_empty_dir($pathdir.'/'.$a))//是否为空
                      {//如果不是，调用自身，不过是原来的路径+他下级的目录名
                          $this->deltree($pathdir.'/'.$a);
                      }
                      if($this->is_empty_dir($pathdir.'/'.$a))
                      {//如果是空就直接删除
                      rmdir($pathdir.'/'.$a);
                      }
                  }
              }
            $d->close();          
            echo "必须先删除目录下的所有文件";//我调试时用的
        }
    }
    public function is_empty_dir($pathdir)
    {
        //判断目录是否为空，看除了.和..之外有其他东西不是为空
        $d=opendir($pathdir);
        $i=0;
          while($a=readdir($d)!== false)
          {
            echo 1;
            $i++;
          }
        closedir($d);
        if($i>2){return false;}
        else return true;
    }*/


// 递归删除文件夹
    public function delFile($dir,$file_type='') {
   $dir = input('post.dir');
 //  dump($dir);
   if(is_dir($dir)){      //如果是目录
    $files = scandir($dir);   //返回指定目录中的文件和目录的数组
   // dump($files);
    //打开目录 //列出目录中的所有文件并去掉 . 和 ..
    foreach($files as $filename){
      if($filename!='.' && $filename!='..'){
        if(!is_dir($dir.'/'.$filename)){
          if(empty($file_type)){
            unlink($dir.'/'.$filename);
          }else{
            if(is_array($file_type)){
              //正则匹配指定文件
              if(preg_match($file_type[0],$filename)){
                unlink($dir.'/'.$filename);
              }
            }else{
              //指定包含某些字符串的文件
              if(false!=stristr($filename,$file_type)){
                unlink($dir.'/'.$filename);
              }
            }
          }

        }else{
           $this->delFile($dir.'/'.$filename);
          rmdir($dir.'/'.$filename);
          
        }
      }
    }
  }else{
      //  echo 'asdsad';die;
    if(file_exists($dir)) {
      unlink($dir);
  }
  }
  echo json_encode(array('code'=>1,'msg'=>'清除成功'));exit;
}

	/**
	* @author liuqin
	*/
    public function index()
    {
      $dir=RUNTIME_PATH;
     $this->assign('dir',$dir);
        if(empty(session('uid'))){
            return $this->fetch('login');
        }else{
            return $this->fetch();
        }
    }
    
    /*
     * @author liuqin
     * @time 2017-04-05
     * @name  登录
     */
    public function login(){
        if(!empty($_POST)){
            $data['username'] = $_POST['userName'];
            $data['password'] = md5($_POST['password']);
            $user = Db::connect('admin_db')->name('empty')->where($data)->find();
          //  var_dump(Db::connect('admin_db')->name('user')->getlastsql());
            if(!empty($user)){ 
                        session('username', $user['username']);
                        session('true_name', $user['true_name']);
                        session('icon', $user['icon']);
                        session('uid', $user['id']);
                        session('role_id',$user['role_id']);
                echo json_encode(array('code'=>1,'msg'=>'登录成功'));exit;
                //return $this->fetch('login');
            }else{
                echo json_encode(array('code'=>0,'msg'=>'登录失败'));exit;
            }
        }else{
            return $this->fetch();
        }
    }
    
     /*
     * @author liuqin
     * @time 2017-04-12
     * @name  退出登录
     */
    public function loginout(){
        session('username', '');
        session('true_name', '');
        session('icon', '');
        session('uid', '');
        session('role_id','');
        return $this->fetch('login');
    }
    
    /*
     * @author liuqin
     * @time 2017-04-12
     * @name  修改密码
     */
    public function password(){
        if(!empty($_POST)){
           // var_dump($_POST);
            $data['id'] = session('uid');
            $data['password'] = md5($_POST['password']);
            $user = Db::connect('admin_db')->name('user')->where($data)->find();
            if($_POST['npwd']!=$_POST['qpwd']){
                echo json_encode(array('code'=>0,'msg'=>'新密码与确认新密码不一致'));exit;
            }
            if(!empty($user)){
                $datas['id'] = session('uid');
                $datas['password'] = md5($_POST['npwd']);
                $map = Db::connect('admin_db')->name('user')->update($datas);
                if($map){
                    echo json_encode(array('code'=>1,'msg'=>'操作成功'));exit;
                }else{
                    echo json_encode(array('code'=>0,'msg'=>'操作失败'));exit;
                }
            }else{
                echo json_encode(array('code'=>0,'msg'=>'旧密码错误'));exit;
            }
        }else{
            $this->assign('user',session('uid'));
            return $this->fetch();
        }
    }
    
	/*
	 *@author liuqin
	 *@function 获取权限信息
	 */
	public function myrule(){
		if(empty(session('uid'))){//未登录
           // return $this->fetch('login');
        }else{
            $uid = session('uid');
            $map ['id'] = session('role_id');
            $map ['status'] = 1; // 角色应该是激活状态
            // $authgroup = M ('auth_group','kt_','course_db')->where ($map)->find ();
			$rule = Db::connect('admin_db')->name('auth_group')->where ($map)->find();
            if(empty($rule)){//角色不存在
                
            }else{
                $nodearray = explode ( ',', $rule['rules'] );
                $nodemap ['id'] = array ('in', $nodearray );
                $nodes = Db::connect('admin_db')->name('auth_rule')->where ($nodemap)->select ();
                // 合并已有权限的节点路径，得到父路径节点的集合
                for($j = 0; $j < count ( $nodes ); $j ++) {
                    $path = explode ( ',', $nodes [$j] ['path'] );
                    $nodearray = array_unique ( array_merge ( $nodearray, $path ) );
                }
                // 将0节点放入数组，查根节点
                // 找到所有节点，构造树
               $myrule = $this->readAuthFunc ( $uid, $nodearray );
               echo json_encode(array('code'=>0,'msg'=>'旧密码错误','data'=>$myrule));exit;
            }
           // return $this->fetch();
        }
	}
    
    /**
     * 读取功能权限
     * @param type $uid
     * @return type
     */
    protected function readAuthFunc($uid, $nodes) {
        $modelname = 'admin';//MODULE_NAME;
        $authmodel = Db::connect('admin_db')->name('auth_rule');
        $map ['group'] = $modelname;
        $map ['pid'] = 0;
        $map ['id'] = array ('in', $nodes );
        $map ['status'] = 1; // 启用状态
        $map ['isbutton'] = 0; // 功能节点
                              // 先读取所有，权限生效，加上id in（1,2,3）
                              // 设置了子节点有权限，则默认应该是对父节点也有权限，递归找到根节点，此处应该遍历用户
        $dataauth = $authmodel->where ( $map )->order ( 'sortorder asc,id asc' )->select ();
        $funcs = array ();
        for($index = 0; $index < count ( $dataauth ); $index ++) {
            // 给每个功能设置一个键
            $data = $dataauth [$index];
            $mas['title'] = $data['title'];
            $mas['icon'] = $data['icon'];
            $mas['spread'] = 'false';
            // 查找子功能
            $pid = $data ['id'];
            $this->getChildNode ( $pid, $mas, $nodes );
            
            //$funcs ['index' . $index] = $data;
            $funcs [$index] = $mas;//$data;
        }
       // S ( $modelname . 'Auth' . $uid, $funcs );
        //var_dump($funcs);
        return $funcs;
    }

    /**
     * 获取子功能节点
     *
     * @param type $pid
     */
    private function getChildNode($pid, &$pdata, $nodes) {
        $modelname = 'admin';//MODULE_NAME;
        $authmodel = Db::connect('admin_db')->name('auth_rule');
        $map ['group'] = $modelname;
        $map ['pid'] = $pid;
        $map ['id'] = array ('in', $nodes );
        $map ['status'] = 1; // 启用状态
        $map ['isbutton'] = 0; // 功能节点
                              // 先读取所有，权限生效，加上id in（1,2,3）
        $dataauth = $authmodel->where ( $map )->order ( 'sortorder asc,id asc' )->select ();
        $funcs = array ();
        for($index = 0; $index < count ( $dataauth ); $index ++) {
            // 给每个功能设置一个键
            $data = $dataauth [$index];
           // var_dump($data);
            $mas['title'] = $data['title'];
            $mas['icon'] = $data['icon'];
            $mas['href'] = 'http://localhost/zsrc/admin.php/'.$data['url'];
            // 查找子功能
            $pid = $data ['id'];
            $this->getChildNode ( $pid, $data, $nodes );
            //$funcs ['index' . $index] = $data;
            $funcs [$index] = $mas;//$data;
        }
        if(!empty($funcs)){
            $pdata ['children'] = $funcs;
        }
    }
    
    
    
    
    
    
    
    
}
