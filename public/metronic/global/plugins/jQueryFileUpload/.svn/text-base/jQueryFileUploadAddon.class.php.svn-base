<?php
namespace Addons\jQueryFileUpload;
use Common\Controller\Addon;
/**
 * @date 2014-4-10
 * @author tww <merry2014@vip.qq.com>
 */
class jQueryFileUploadAddon extends Addon{
	
	public $info = array(
			'name'=>'jQueryFileUpload',
			'title'=>'jquery图片批量上传',
			'description'=>'根据jqueryFileUpload修改',
			'status'=>1,
			'author'=>'tww',
			'version'=>'0.1'
	);
	
	public function install(){
		return true;	
	}

	public function uninstall(){	
		return true;		
	}
	
	public function jqFileUpload(){
		$config = $this->getConfig();
		$this->assign('addons_config', $config);
		$this->display('upload');
	}

	
}