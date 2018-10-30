<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Talk extends Model
{
	/**
	* @author liuqin
	* @function 获取好友动态和评论
	* @time 2017-04-13
	*/
	public function get_talks()
	{
		$uid = session('uid');
		$friends = model('friend')->get_friends($uid);
		$strings = $friends['strings'].$uid;
		$where['user_id'] = ['in',$strings];
		$where['is_del'] = 0;
		$db = Db::connect('admin_db');
		if(input('get.tip') == 'aboutme'){
			$where['mention'] = ['like','%'.$uid.'%'];
		}
		$talks = $db->name('talk')->where($where)->order('pub_time desc')->limit(10)->select();
		foreach($talks as $k=>$v){
			if(!empty($v['img'])){
				$arr = explode(',',$v['img']);
				$talks[$k]['imgs'] = $arr;
			}
			if(!empty($v['likes'])){
				$where_like = [];
				$where_like['id'] = ['in',$v['likes']];
				$users = $db->name('user')->where($where_like)->field('id,true_name')->select();
				$talks[$k]['like_names'] = $users;
			}
			if($v['first_id'] != 0){
				$first_talk = $db->name('talk')->find($v['first_id']);
				$user = $db->name('user')->find($first_talk['user_id']);
				$first_talk['true_name'] = $user['true_name'];
				$talks[$k]['first_talk'] = $first_talk;
			}
			$user = $db->name('user')->find($v['user_id']);
			$talks[$k]['icon'] = $user['icon'];
			$talks[$k]['true_name'] = $user['true_name'];
			$firsts = $db->name('talk_comment')->where(['talk_id'=>$v['id'],'first_id'=>0,'is_del'=>0])->order('create_time asc')->select();
			foreach($firsts as $kk=>$vv){
				$user = $db->name('user')->find($vv['create_userid']);
				$firsts[$kk]['create_icon'] = $user['icon'];
				$firsts[$kk]['create_username'] = $user['true_name'];
				$user = $db->name('user')->find($vv['reply_userid']);
				$firsts[$kk]['reply_icon'] = $user['icon'];
				$firsts[$kk]['reply_username'] = $user['true_name'];
				$childs = $db->name('talk_comment')->where(['first_id'=>$vv['id'],'is_del'=>0])->order('create_time asc')->select();
				foreach($childs as $kkk=>$vvv){
					$user = $db->name('user')->find($vvv['create_userid']);
					$childs[$kkk]['create_icon'] = $user['icon'];
					$childs[$kkk]['create_username'] = $user['true_name'];
					$user = $db->name('user')->find($vvv['reply_userid']);
					$childs[$kkk]['reply_icon'] = $user['icon'];
					$childs[$kkk]['reply_username'] = $user['true_name'];
				}
				$firsts[$kk]['childs'] = $childs;
			}
			$talks[$k]['firsts'] = $firsts;
		}
		$return ['talks'] = $talks;
		$return ['friends'] = $friends['arrays'];
		return $return;
	}
}