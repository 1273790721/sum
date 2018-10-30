<?php
namespace app\admin\controller;
use think\Controller;
class Login extends Controller
{
	/**
	* @author liuqin
	*/
	public function sync()
	{
		return $this->fetch();
	}
}