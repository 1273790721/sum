<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Citys extends Controller
{
	/**
	* @author chenkun
	* @function 省市联动
	* @time 2017-04-12
	*/
	public function index()
	{
		return $this->fetch();
	}
	public function getcity()
	{
		$return = Db::connect('admin_db')->name('city')->where(['pid'=>0])->select();
		echo json_encode($return);
	}
	public function getparent()
	{
		$id = input('id');
		$return = Db::connect('admin_db')->name('city')->where(['pid'=>$id])->select();
		echo json_encode($return);
	}
}