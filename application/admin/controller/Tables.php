<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Tables extends Controller
{
	/**
	 * @author liuqin
     * @function 获取列表信息
     * @time 2017-04-05
	*/
    public function index()
    {
        $list = db('submit','admin_db')->select();
        foreach ($list as $k=>$v){
            if($v['sex']==1){
                $list[$k]['sex'] = '男';
            }else{
                $list[$k]['sex'] = '女';
            }
        }
        $this->assign('lists',$list);
       // var_dump($list);
        return $this->fetch();
    }
    
    /*
     * @author liuqin
     * @function 删除
     */
    public function deletes(){
      //  var_dump($_POST);
        $id = $_POST['id'];//input('post.id');
       // var_dump($id);exit;
		$result = Db::connect('admin_db')->name('submit')->delete($id);
		if($result){
			echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit;
		}else{
			echo json_encode(array('code'=>0,'msg'=>'删除失败'));exit;
		}
    }
    
    /**
     * @author liuqin
     * @function 导出功能
     * @time 2017-04-06
	*/
    public function export()
    {
        $list = db('submit','admin_db')->select();
        foreach ($list as $k=>$v){
            if($v['sex']==1){
                $list[$k]['sex'] = '男';
            }else{
                $list[$k]['sex'] = '女';
            }
        }
    	$file_name = '批量操作报表导出数据' . date('YmdGis');
        $title_arr = array('姓名','性别','年龄','备注');
        $keys = array('name','sex','age','mark');
        $excel = new \Common\Logic\PhpExcelLogic();
        $excel->exportExcel($list, $keys, $file_name, $title_arr);
    }
    /**
     * @author liuqin
     * @function 上传excel
     * @time 2017-04-11
    */
    public function upload_excel()
    {
        $file = Request::instance()->file('excel');
        $check = ['ext','xls,xlsx'];
        $info = $file->validate($check)->move(ROOT_PATH.'public'.DS.'upload/excel');
        if($info){
            $url = 'public/upload/excel/'.$info->getSaveName();
            $url = str_replace('\\','/',$url);
            echo json_encode(['code'=>1,'msg'=>'上传成功','url'=>$url]);exit;
        }else{
            echo json_encode(['code'=>0,'msg'=>'上传失败']);exit;
        }

    }
    /**
     * @author liuqin
     * @function 导入excel
     * @time 2017-04-11
    */
    public function excel(){
        Vendor('PHPExcel.PHPExcel');
        $file = input('post.url');
        if(file_exists($file) === false){
            echo json_encode(['code'=>0,'msg'=>'文件不存在']);exit;
        }
        $phpreader = new \PHPExcel_Reader_Excel2007();
        if($phpreader->canRead($file) === false){
            $phpreader = new \PHPExcel_Reader_Excel5();
            if($phpreader->canRead($file) === false){
                echo json_encode(['code'=>0,'msg'=>'格式不对']);exit;
            }
        }
        $phpexcel = $phpreader->load($file);
        $sheetcount = $phpexcel->getSheetCount();
        $count = $sheetcount - 1;
        $db = Db::connect('admin_db');
        $db->startTrans();
        try{
            for($i=0;$i<=$count;$i++){
                $sheet = $phpexcel->getSheet($i);
                $arr = $sheet->toArray();
                array_shift($arr);
                $data = [];
                foreach($arr as $k=>$v){
                    $tip = '第'.($i+1).'个工作表第'.($k+2).'行的';
                    $data['name'] = $v[0];
                    if(empty(trim($v[0]))){
                        $msg = $tip.'姓名不能为空';
                        echo json_encode(['code'=>0,'msg'=>$msg]);exit;
                    }
                    if(!empty(trim($v[1]))){
                        $data['sex'] = $v[1];
                    }
                    if(!empty(trim($v[2]))){
                        $data['age'] = $v[2];
                    }
                    if(!empty(trim($v[3]))){
                        $data['mark'] = $v[3];
                    }
                    $db->name('submit')->insert($data);
                }
            }
            $db->commit();
            echo json_encode(['code'=>1,'msg'=>'导入成功']);exit;
        }catch(\Exception $e){
            $db->rollback();
            echo json_encode(['code'=>0,'msg'=>'导入失败']);exit;
        }
    }
    
}
