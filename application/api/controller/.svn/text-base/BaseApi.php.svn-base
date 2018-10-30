<?php
namespace app\api\controller;
//namespace UIKit\Controller;
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Accept");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Origin: *");
use think\Controller;

class BaseApi extends Controller {
    protected $pagenum=10;
  protected function _initialize() {
//        $this->userid = I('uid');
//        if(!empty($this->userid)){
//            if($this->userid != -1){
//            $use_maps['id']=I('uid');
//            $use_maps['isdel']=0;
//            $is_user_mape = M("user") ->where($use_maps) ->find();
//                if(empty($is_user_mape)){
//                     $this->ErrorReturn('用户不合法，请重新登录');
//                }
//            }
//        }
    }
    //成功返回
    public function SuccessReturn($result) {
        if (empty($result)) {
            $result['status'] = 1;
            $result['info'] = "";
        } else {
            $result['status'] = 1;
            if (empty($result['info'])) {
                $result['info'] = "";
            }
        }

        //扩展ajax返回数据, 在Action中定义function ajaxAssign(&$result){} 方法 扩展ajax返回数据。
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($result));
    }

    public function SuccessReturnInfo($info, $status = 1) {
        $result = array();
        $result['status'] = $status;
        $result['info'] = $info;
        //扩展ajax返回数据, 在Action中定义function ajaxAssign(&$result){} 方法 扩展ajax返回数据。
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($result));
    }

    //返回失败
    public function ErrorReturn($info, $status = 0) {
        $result = array();
        $result['status'] = $status;
        $result['info'] = $info;
        //扩展ajax返回数据, 在Action中定义function ajaxAssign(&$result){} 方法 扩展ajax返回数据。
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($result));
    }

    public function wipeOffNull($para) {
        if (empty($para) || $para == "null") {
            return "0";
        }else{
            return $para;
        }
    }

    /**
     * 写入APP日志
     * @param int $nUid
     * @param String $sLog
     */
    public function write_app_log($nUid){
        $aLog = array();
        if(!empty($nUid)){
            $aLog['uid'] = $nUid;
            $aLog['create_date'] = date("Y-m-d H:i:s",time());
            M("user_report")->add($aLog);
        }
    }
}