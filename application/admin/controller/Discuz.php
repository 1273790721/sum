<?php
namespace app\admin\controller;
use think\Controller;
class Discuz extends Controller
{
	/**
	* @author liuqin
	* @function 论坛
	* @time 2017-04-17
	*/
	public function index()
	{
		return $this->fetch();
	}
}