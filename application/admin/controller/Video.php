<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Video extends Controller
{
	/**
	* @author 黄河水
	* @function 视频播放器
	* @time 2017-04-18
	*/
	public function index()
	{
		return $this->fetch();
	}
}