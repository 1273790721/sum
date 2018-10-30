<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Datex extends Controller
{
	/**
	* @author 黄河水
	* @function popup弹出框
	* @time 2017-04-20
	*/
	public function index()
	{
		return $this->fetch();
	}
}