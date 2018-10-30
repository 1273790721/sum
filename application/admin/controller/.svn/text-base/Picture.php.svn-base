<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Picture extends Controller
{
	/**
	 * @author liuqin
     * @function 图片上传界面
     * @time 2017-04-06
	*/
    public function index()
    {
        
       // var_dump($list);
        return $this->fetch();
    }
    
    /**
	 * @author liuqin
     * @function 处理上传图片
     * @time 2017-04-06
	*/
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//不验证上传文件格式
       // $info = $file->validate(['size'=>15678,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');//验证上传文件格式
        if($info){
            // $image = \think\Image::open(request()->file('image'));
            $image = \think\Image::open("./public/uploads/".date('Ymd').'/'.$info->getFilename());
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
            //$image->thumb(150, 150)->save('./public/uploads/thumb/'.date('YmdHis').'.'.$info->getExtension());
            $image->thumb(150, 150)->save("./public/uploads/".date('Ymd').'/thumb_'.$info->getFilename());//生成缩略图
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
	
}