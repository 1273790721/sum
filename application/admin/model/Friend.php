<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Friend extends Model
{
	/**
	* @author liuqin
	* @function 获取用户好友
	* @time 2017-04-13
	*/
	public function get_friends($id)
	{
		$me['user_id'] = $id;
		$me['status'] = 1;
		$me['is_del'] = 0;
		$ta['friend_id'] = $id;
		$ta['status'] = 1;
		$ta['is_del'] = 0;
		$db = Db::connect('admin_db');
		$mes = $db->name('friend')->where($me)->select();
		$data = '';
		$friends = [];
		foreach($mes as $v){
			$data .= $v['friend_id'].',';
			$user = $db->name('user')->find($v['friend_id']);
			$friends[$user['id']] = $user['true_name'];
		}
		$tas = $db->name('friend')->where($ta)->select();
		foreach($tas as $v){
			$data .= $v['user_id'].',';
			$user = $db->name('user')->find($v['user_id']);
			$friends[$user['id']] = $user['true_name'];
		}
		$return['strings'] = $data;
		$return['arrays'] = $friends;
		return $return;
	}
}