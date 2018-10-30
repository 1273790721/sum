<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Friend extends Controller
{
	/**
	* @author liuqin
	* @function 朋友圈列表和发表
	* @time 2017-04-12
	*/
	public function index()
	{
		if(Request::instance()->isPost()){
			$data = input('post.');
			$data['user_id'] = session('uid');
			$data['pub_time'] = date('Y-m-d H:i:s');
			$data['img'] = trim($data['img'],',');
			$db = Db::connect('admin_db');
			$result = $db->name('talk')->insertGetId($data);
			if($result){
				$talk = $db->name('talk')->find($result);
				$user = $db->name('user')->find($talk['user_id']);
				$talk['icon'] = $user['icon'];
				$talk['true_name'] = $user['true_name'];
				if(!empty($talk['img'])){
					$arr = explode(',',$talk['img']);
					$talk['imgs'] = $arr;
				}
				echo json_encode(['code'=>1,'msg'=>'发表成功','data'=>$talk]);exit;
			}else{
				echo json_encode(['code'=>0,'msg'=>'发表失败']);exit;
			}
		}else{
			//获取好友动态和评论
			$talks = model('talk')->get_talks();
			$this->assign('talks',$talks['talks']);
			$this->assign('friends',$talks['friends']);
			//dump($talks['talks'][6]['like_names']);exit;
			return $this->fetch();
		}
	}
	/**
	* @author liuqin
	* @function 朋友圈评论
	* @time 2017-04-12
	*/
	public function comment()
	{
		$type = input('post.type');
		if($type == 0){
			$db = Db::connect('admin_db');
			$talk = $db->name('talk')->find(input('post.id'));
			$user = $db->name('user')->find($talk['user_id']);
			$data['talk_id'] = input('post.id');
			$data['content'] = input('post.content');
			$data['create_userid'] = session('uid');
			$data['create_username'] = session('true_name');
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['reply_userid'] = $user['id'];
			$data['reply_username'] = $user['true_name'];
			$db->startTrans();
			try{
				$new = $db->name('talk_comment')->insertGetId($data);
				$comment = $db->name('talk_comment')->find($new);
				$user = $db->name('user')->find($comment['create_userid']);
				$comment['create_icon'] = $user['icon'];
				$db->name('talk')->where(['id'=>$data['talk_id']])->setInc('com_num',1);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>'评论成功','data'=>$comment]);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>'评论失败']);exit;
			}
		}elseif($type == 1){
			$id = input('post.id');
			$db = Db::connect('admin_db');
			$comment = $db->name('talk_comment')->find($id);
			$data['talk_id'] = $comment['talk_id'];
			$data['content'] = input('post.content');
			$data['create_userid'] = session('uid');
			$data['create_username'] = session('true_name');
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['reply_id'] = $id;
			if($comment['first_id'] == 0){
				$data['first_id'] = $id;
			}else{
				$data['first_id'] = $comment['first_id'];
			}
			$data['reply_userid'] = $comment['create_userid'];
			$data['reply_username'] = $comment['create_username'];
			try{
				$new = $db->name('talk_comment')->insertGetId($data);
				$comment = $db->name('talk_comment')->find($new);
				$user = $db->name('user')->find($comment['create_userid']);
				$comment['create_icon'] = $user['icon'];
				$comment['create_username'] = $user['true_name'];
				$user = $db->name('user')->find($comment['reply_userid']);
				$comment['reply_icon'] = $user['icon'];
				$comment['reply_username'] = $user['true_name'];
				$db->name('talk')->where(['id'=>$data['talk_id']])->setInc('com_num',1);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>'回复成功','data'=>$comment]);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>'回复失败']);exit;
			}
		}
	}
	/**
	* @author liuqin
	* @function 朋友圈点赞
	* @time 2017-04-12
	*/
	public function like()
	{
		$id = input('post.id');
		$db = Db::connect('admin_db');
		$talk = $db->name('talk')->find($id);
		$uid = session('uid');
		settype($uid,'string');
		//未点赞
		if(strpos($talk['likes'],$uid) === false){
			$data['like_num'] = $talk['like_num'] + 1;
			$data['likes'] = $talk['likes'].session('uid').',';
			$result = $db->name('talk')->where(['id'=>$id])->update($data);
			if($result){
				$where_like['id'] = ['in',$data['likes']];
				$users = $db->name('user')->where($where_like)->field('id,true_name')->select();
				$return['data'] = $users;
				$return['like_num'] = $data['like_num'];
				echo json_encode(['code'=>1,'msg'=>'点赞成功','data'=>$return]);exit;
			}else{
				echo json_encode(['code'=>0,'msg'=>'点赞失败']);exit;
			}
		}
		//已点赞
		else{
			$data['like_num'] = $talk['like_num'] - 1;
			if(strpos($talk['likes'],','.$uid.',') === false){
				if(strpos($talk['likes'],','.$uid) === false){
					if(strpos($talk['likes'],$uid.',') === false){
						$str = str_replace($uid,'',$talk['likes']);
					}else{
						$str = str_replace($uid.',','',$talk['likes']);
					}
				}else{
					$str = str_replace(','.$uid,'',$talk['likes']);
				}
			}else{
				$str = str_replace(','.$uid,'',$talk['likes']);
			}
			$data['likes'] = $str;
			$result = $db->name('talk')->where(['id'=>$id])->update($data);
			if($result){
				if(!empty($str)){
					$where_like['id'] = ['in',$str];
					$users = $db->name('user')->where($where_like)->field('id,true_name')->select();
					$return['data'] = $users;
					$return['like_num'] = $data['like_num'];
				}else{
					$return = '';
				}
				echo json_encode(['code'=>1,'msg'=>'取消成功','data'=>$return]);exit;
			}else{
				echo json_encode(['code'=>0,'msg'=>'取消失败']);exit;
			}
		}
	}
	/**
	* @author liuqin
	* @function 朋友圈转发
	* @time 2017-04-14
	*/
	public function send()
	{
		if(Request::instance()->isPost()){
			$pid = input('post.pid');
			$db = Db::connect('admin_db');
			$talk = $db->name('talk')->find($pid);
			$data = input('post.');
			$data['user_id'] = session('uid');
			if($talk['first_id'] == 0){
				$data['first_id'] = $pid;
			}else{
				$data['first_id'] = $talk['first_id'];
			}
			$data['pub_time'] = date('Y-m-d H:i:s');
			$db->startTrans();
			try{
				$db->name('talk')->insert($data);
				$db->name('talk')->where(['id'=>$data['first_id']])->setInc('send_num',1);
				$db->commit();
				echo json_encode(['code'=>1,'msg'=>'转发成功']);exit;
			}catch(\Exception $e){
				$db->rollback();
				echo json_encode(['code'=>0,'msg'=>'转发失败']);exit;
			}
		}else{
			return $this->fetch();
		}
	}

}