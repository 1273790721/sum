<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Blog extends Controller
{
	/**
	* @author liuqin
	* @function 博客列表功能
	* @time 2017-04-07
	*/
	public function index()
	{
		$where['u_id'] = 1;
		$where['is_pub'] = 1;
		$where['is_del'] = 0;
		$field = 'id,title,author,update_time,top_num,reprint';
		$order = 'top_num desc,update_time desc';
		$blogs = Db::connect('admin_db')->name('blog')->where($where)->field($field)->order($order)->paginate(10);
		$this->assign('blogs',$blogs);
		return $this->fetch();
	}
	/**
	* @author liuqin
	* @function 博客查看功能
	* @time 2017-04-10
	*/
	public function read()
	{
		$id = input('get.id');
		$db = Db::connect('admin_db');
		$field = 'id,title,update_time,keyword,like,reply_number,reprint_num,is_com,is_achievement';
		$blog = $db->name('blog')->field($field)->find($id);
		$data = $db->name('blog_data')->where(['id'=>$blog['is_achievement']])->find();
		$blog['content'] = $data['content'];
		$this->assign('blog',$blog);
		if($blog['is_com'] == '1'){
			$comments = $db->name('blog_reply')->where(['b_id'=>$id,'replyid'=>0])->order('create_time desc')->select();
			foreach($comments as $k=>$v){
				$replys = $db->name('blog_reply')->where(['replyid'=>$v['id']])->order('create_time desc')->select();
				$comments[$k]['replys'] = $replys;
			}
		}else{
			$comments = '';
		}
		$this->assign('comments',$comments);
		return $this->fetch();
	}
	/**
	* @author liuqin
	* @function 博客添加功能
	* @time 2017-04-07
	*/
	public function add()
	{
		if(Request::instance()->isPost()){
			$blog['title'] = input('post.title');
			if(trim($blog['title']) == ''){
				echo json_encode(['code'=>0,'msg'=>'标题不能为空']);exit;
			}
			$blog['type'] = input('post.type');
			$blog['keyword'] = input('post.keyword');
			$blog['is_com'] = input('post.is_com');
			$blog['is_rep'] = input('post.is_rep');
			$content['content'] = input('post.content');
			if(trim($content['content']) == ''){
				echo json_encode(['code'=>0,'msg'=>'内容不能为空']);exit;
			}
			$blog['is_pub'] = input('post.is_pub');
			if($blog['is_pub'] == '1'){
				$msg = '发布';
			}elseif($blog['is_pub'] == '0'){
				$msg = '保存';
			}
			$blog['u_id'] = 1;
			$blog['author'] = 'admin';
			$blog['create_time'] = date('Y-m-d H:i:s');
			$blog['update_time'] = date('Y-m-d H:i:s');
			$db = Db::connect('admin_db');
			$db->startTrans();
			try{
				$id = $db->name('blog')->insertGetId($blog);
				$db->name('blog')->where(['id'=>$id])->update(['is_achievement'=>$id]);
				$content['id'] = $id;
				$db->name('blog_data')->insert($content);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>$msg.'成功']);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>$msg.'失败']);exit;
			}
		}else{
			return $this->fetch();
		}
	}
	/**
	* @author liuqin
	* @function 博客置顶功能
	* @time 2017-04-10
	*/
	public function top()
	{
		$type = input('post.type');
		$id = input('post.id');
		if($type == 1){
			$where['u_id'] = 1;
			$where['is_pub'] = 1;
			$where['is_del'] = 0;
			$order = 'top_num desc';
			$blog = Db::connect('admin_db')->name('blog')->where($where)->order($order)->find();
			$save['top_num'] = $blog['top_num'] + 1;
			$result = Db::connect('admin_db')->name('blog')->where(['id'=>$id])->update($save);
			if($result){
				echo json_encode(['code'=>1,'msg'=>'置顶成功']);exit;
			}else{
				echo json_encode(['code'=>0,'msg'=>'置顶失败']);exit;
			}
		}else{
			$save['top_num'] = 0;
			$result = Db::connect('admin_db')->name('blog')->where(['id'=>$id])->update($save);
			if($result){
				echo json_encode(['code'=>1,'msg'=>'取消置顶成功']);exit;
			}else{
				echo json_encode(['code'=>0,'msg'=>'取消置顶失败']);exit;
			}
		}
	}
	/**
	* @author liuqin
	* @function 博客删除功能
	* @time 2017-04-10
	*/
	public function del()
	{
		$id = input('post.id');
		$result = Db::connect('admin_db')->name('blog')->where(['id'=>$id])->update(['is_del'=>1]);
		if($result){
			echo json_encode(['code'=>1,'msg'=>'删除成功']);exit;
		}else{
			echo json_encode(['code'=>0,'msg'=>'删除失败']);exit;
		}
	}
	/**
	* @author liuqin
	* @function 博客草稿箱功能
	* @time 2017-04-10
	*/
	public function box()
	{
		$where['u_id'] = 1;
		$where['is_pub'] = 0;
		$where['is_del'] = 0;
		$field = 'id,title,author,create_time';
		$order = 'create_time desc';
		$blogs = Db::connect('admin_db')->name('blog')->where($where)->field($field)->order($order)->paginate(10);
		$this->assign('blogs',$blogs);
		return $this->fetch();
	}
	/**
	* @author liuqin
	* @function 博客修改功能
	* @time 2017-04-10
	*/
	public function upd()
	{
		if(Request::instance()->isPost()){
			$id = input('post.id');
			$blog['title'] = input('post.title');
			if(trim($blog['title']) == ''){
				echo json_encode(['code'=>0,'msg'=>'标题不能为空']);exit;
			}
			$blog['type'] = input('post.type');
			$blog['keyword'] = input('post.keyword');
			$blog['is_com'] = input('post.is_com');
			$blog['is_rep'] = input('post.is_rep');
			$content['content'] = input('post.content');
			if(trim($content['content']) == ''){
				echo json_encode(['code'=>0,'msg'=>'内容不能为空']);exit;
			}
			$blog['is_pub'] = input('post.is_pub');
			if($blog['is_pub'] == '1'){
				$msg = '发布';
			}elseif($blog['is_pub'] == '0'){
				$msg = '保存';
			}
			$blog['update_time'] = date('Y-m-d H:i:s');
			$db = Db::connect('admin_db');
			$db->startTrans();
			try{
				$db->name('blog')->where(['id'=>$id])->update($blog);
				$db->name('blog_data')->where(['id'=>$id])->update($content);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>$msg.'成功']);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>$msg.'失败']);exit;
			}
		}else{
			$id = input('get.id');
			$where['id'] = $id;
			$where['u_id'] = 1;
			$where['is_pub'] = 0;
			$where['is_del'] = 0;
			$db = Db::connect('admin_db');
			$blog = $db->name('blog')->where($where)->find();
			$data = $db->name('blog_data')->where(['id'=>$blog['is_achievement']])->find();
			$blog['content'] = $data['content'];
			$this->assign('blog',$blog);
			return $this->fetch();
		}
	}
	/**
	* @author liuqin
	* @function 博客发布功能
	* @time 2017-04-10
	*/
	public function pub()
	{
		$id = input('post.id');
		$result = Db::connect('admin_db')->name('blog')->where(['id'=>$id])->update(['is_pub'=>1]);
		if($result){
			echo json_encode(['code'=>1,'msg'=>'发布成功']);exit;
		}else{
			echo json_encode(['code'=>0,'msg'=>'发布失败']);exit;
		}
	}
	/**
	* @author liuqin
	* @function 判断博客是否可以评论
	* @time 2017-04-11
	*/
	public function judge_comment()
	{
		$id = input('post.id');
		$blog = Db::connect('admin_db')->name('blog')->find($id);
		if($blog['is_com'] == '0'){
			echo json_encode(['code'=>0,'msg'=>'该博文禁止评论']);exit;
		}else{
			echo json_encode(['code'=>1]);exit;
		}
	}
	/**
	* @author liuqin
	* @function 博客评论功能
	* @time 2017-04-11
	*/
	public function comment()
	{
		$type = input('post.type');
		if($type == '0'){
			$data['b_id'] = input('post.id');
			$data['content'] = input('post.content');
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['create_userid'] = 1;
			$data['create_username'] = 'admin';
			$db = Db::connect('admin_db');
			$db->startTrans();
			try{
				$db->name('blog_reply')->insertGetId($data);
				$db->name('blog')->where(['id'=>input('post.id')])->setInc('reply_number',1);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>'评论成功']);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>'评论失败']);exit;
			}
		}elseif($type == '1'){
			$id = input('post.id');
			$db = Db::connect('admin_db');
			$comm = $db->name('blog_reply')->find($id);
			$data['b_id'] = $comm['b_id'];
			$data['content'] = input('post.content');
			$data['replyid'] = $id;
			$data['replyuser'] = $comm['create_userid'];
			$data['reply_username'] = $comm['create_username'];
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['create_userid'] = 1;
			$data['create_username'] = 'admin';
			$db = Db::connect('admin_db');
			$db->startTrans();
			try{
				$db->name('blog_reply')->insertGetId($data);
				$db->name('blog')->where(['id'=>$comm['b_id']])->setInc('reply_number',1);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>'回复成功']);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>'回复失败']);exit;
			}
		}
	}
	/**
	* @author liuqin
	* @function 判断博客是否可以转载
	* @time 2017-04-11
	*/
	public function judge_reprint()
	{
		$id = input('post.id');
		$blog = Db::connect('admin_db')->name('blog')->find($id);
		if($blog['is_rep'] == '0'){
			echo json_encode(['code'=>0,'msg'=>'该博文禁止转载']);exit;
		}else{
			echo json_encode(['code'=>1]);exit;
		}
	}
	/**
	* @author liuqin
	* @function 博客转载功能
	* @time 2017-04-11
	*/
	public function reprint()
	{
		$id = input('post.id');
		$db = Db::connect('admin_db');
		$blog = $db->name('blog')->find($id);
		$data['title'] = $blog['title'];
		$data['type'] = 1;
		$data['keyword'] = $blog['keyword'];
		$data['is_pub'] = $blog['is_pub'];
		$data['u_id'] = $blog['u_id'];
		$data['reprint'] = 1;
		$data['create_time'] = date('Y-m-d H:i:s');
		$data['update_time'] = date('Y-m-d H:i:s');
		$data['is_rep'] = 1;
		$data['is_com'] = 1;
		$data['is_achievement'] = $blog['is_achievement'];
		$data['author'] = 'admin';
		$db->startTrans();
		try{
			$db->name('blog')->insert($data);
			$db->name('blog')->where(['id'=>$id])->setInc('reprint_num',1);
			$db->commit();
			echo json_encode(['code'=>1,'msg'=>'转载成功']);exit;
		}catch(\Exception $e){
			$db->rollback();
			echo json_encode(['code'=>0,'msg'=>'转载失败']);exit;
		}
	}
	/**
	* @author liuqin
	* @function 博客点赞功能
	* @time 2017-04-11
	*/
	public function like(){
		$id = input('post.id');
		$db = Db::connect('admin_db');
		$blog = $db->name('blog')->field('id,like')->find($id);
		$data['like'] = $blog['like'] + 1;
		$result = $db->name('blog')->where(['id'=>$id])->update($data);
		if($result){
			echo json_encode(['code'=>1,'msg'=>'点赞成功','result'=>$data['like']]);exit;
		}else{
			echo json_encode(['code'=>0,'msg'=>'点赞失败']);exit;
		}
	}
}