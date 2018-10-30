<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Upload extends Controller
{
	/**
	* @author chenkun
	* @function 上传
	* @time 2017-04-12
	*/
	public function index()
	{
		if(Request::instance()->isPost()){
			$files = Request::instance()->file('file');
			$data = [];
			foreach($files as $file){
				$info = $file->move(ROOT_PATH.'public'.DS.'upload/upload');
				if($info){
					$url = $info->getSaveName();
					$url = str_replace('\\','/',$url);
					$data[] = 'public/upload/upload/'.$url;
				}else{
					echo json_encode($file->getError());exit;
				}
			}
			echo json_encode($data);
		}else{
			return $this->fetch();
		}
	}
	/**
	* @author liuqin
	* @function wangeditor上传图片
	* @time 2017-04-17
	*/
	function wang_upload_img()
	{
		$file = Request::instance()->file('wangEditorH5File');
		$info = $file->move(ROOT_PATH.'public'.DS.'upload/wang');
		if($info){
			$url = $info->getSaveName();
			$url = str_replace('\\','/',$url);
			echo config('web_url').'/public/upload/wang/'.$url;
		}else{
			echo 'error|上传失败';
		}
	}
}