<?php

namespace app\admin\controller;

use think\Controller;

class Imagick extends Controller
{
	/**
	* @author liuqin
	* @function pdf转图片
	* @time 2017-04-27
	*/
	public function index()
	{
		return $this->fetch();
	}
}