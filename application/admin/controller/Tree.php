<?php
namespace app\admin\controller;
use think\Controller;
class Tree extends Controller
{
	/**
	* @author liuqin
	*/
	public function index()
	{
		return $this->fetch();
	}
	/**
	* @author liuqin
	*/
	public function ajax_tree()
	{
		$return = 
			[['i'=>1,'tree_name'=>'西游记',
			'children'=>[['i'=>2,'tree_name'=>'第一章'],['i'=>3,'tree_name'=>'第二章']]],
			['i'=>4,'tree_name'=>'三国演义',
			'children'=>[['i'=>5,'tree_name'=>'第一章'],['i'=>6,'tree_name'=>'第二章']]],
		];
		echo json_encode($return);
	}
}