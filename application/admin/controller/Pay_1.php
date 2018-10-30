<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Pay extends Controller
{
	/**
	 * @author liuqin
     * @function 支付宝退款
     * @time 2017-04-06
	*/
    public function index()
    {
         
       // $this->write_log('支付宝退款');
       // $id=I('get.id');
      //  $where['id']=$id;
      //  $aResult=M('theorder')->where($where)->field('transaction_id,pay_money')->find();   
        $pay_money=0.01;//$aResult['pay_money'];
        $transaction_id=201704011222;//$aResult['transaction_id'];//交易订单号
       // $transaction_id='2016072821001004470252052451';  
     //   $pay_money=0.01;
        require_once('./extend/common/function.php');         
        $data['WIDdetail_data']="$transaction_id^$pay_money^提现退款";
        $data['id']=1;
        $data['pay_money']=$pay_money;
        alirefund($data);

       // var_dump($list);
     //   return $this->fetch();
    }
    
    /**
     *支付接口
     */
    public function money(){
        $where['id']=1;
        $is_user = M("help") ->where($where)->find();
        $result['money'] = empty($is_user['cost']) ? '0' : $is_user['cost'];
        $this->SuccessReturn($result);
    }
    
     /**
     *支付接口
     */
    public function order(){
        $data = array();
       // $scale = C('aConfig');
        $id = I('uid');//用户id
       // $id=I('get.uid');
        $num = (int)I('num');//年份
        $money = I('money');//金额
        $type = I('type');//支付类型，1：支付宝支付，2：微信支付
        if(empty($num)){
            $num=1;
        }
        $year=date('Y-',time())+$num-1;
        if(empty($id)){
            $this->ErrorReturn('用户id不能为空',0);
        }
        if($type==4){
            $data['uid'] = $id;
                $data['cost'] = $money;
                $data['type'] = $type;
                $data['date'] = date('Y-m-d',time());
                $data['year_end']=$year;
                $data['limit_date'] = $year.'-12-31';
                $data['status']=1;
                $res = M("user_pay")->add($data);
                if($res){
                    $this->SuccessReturn($result);
                }else{
                    $this->ErrorReturn('提交失败',0);
                }
        }else{
            if(!empty($money)&&$money!=0){
                if($type==1||$type==2){
                    $data['uid'] = $id;
                    $data['cost'] = $money;
                    $data['type'] = $type;
                    $data['date'] = date('Y-m-d',time());
                    $data['year_end']=$year;
                    $data['limit_date'] = $year.'-12-31';
                    $res = M("user_pay")->add($data);
                    if($res!==false){
                        if($type==1){
                           // require C('BASE_PATH').'/ThinkPHP/Library/Btten/Payment/'.$type.'/notify_url.php';
                           // require_once('./ThinkPHP/Library/Btten/Payment/Alipay/notify_url.php');
                            require_once('./ThinkPHP/Library/Btten/Payment/Alipay/order.php');
                           // require_once("./Alipay/lib/alipay_rsa.function.php");
                            //$result['orderinfo'] = array();
                            $result['url'] = pay($res, '路路平安缴费', $money);
                        }else{
                            //$result['orderinfo'] = array();
                            require_once('./ThinkPHP/Library/Btten/Payment/Wpay/order.php');
                            $result['config'] = pay($res, '路路平安缴费', $money);
                        }
                        $result['oid'] = $res;
                        $this->SuccessReturn($result);
                    }else{
                        $this->ErrorReturn('下单失败',0);
                    }
                }else{
                    $this->ErrorReturn('选择支付方式',0);
                }
            }else{
                $this->ErrorReturn('充值金额不合法',0);
            }
        }
    }

 public function notify(){
        
        $type = I('type');
//        if($types==1){
//            $type='Alipay';
//        }
//        if($types==2){
//            $type='Wpay';
//        }
        $type = ucfirst($type);
        !$type and $type = 'Wpay';
       // require C('BASE_PATH').'/ThinkPHP/Library/Btten/Payment/Alipay/notify_url.php';
        require C('BASE_PATH').'/ThinkPHP/Library/Btten/Payment/'.$type.'/notify_url.php';
        //require_once('./ThinkPHP/Library/Btten/Payment/Alipay/notify_url.php');
       // require_once('./ThinkPHP/Library/Btten/Payment/'.$type.'/notify_url.php');
        //require C('BASE_PATH').'/ThinkPHP/Library/Btten/Payment/'.$type.'/notify_url.php';
        
    }
    
//     if($res){
//            //调用接口的order.php处理
//            $type = ucfirst($type);
//            require C('BASE_PATH').'/ThinkPHP/Library/Btten/Payment/'.$type.'/order.php';
//            
//            $config = pay($res, $title, $cash);
//            
//            
//            switch ($type){
//                case 'Alipay':
//                    $result['url'] = $config;
//                    break;
//                case 'Wpay':
//                    $result['config'] = $config;
//                    break;
//            }
//            
//            $result['oid'] = $res;
//            $this->SuccessReturn($result);
//            
//        }else{
//            $info = '订单创建失败';
//            $this->ErrorReturn($info);
//        }
    
    /**
     * 苹果支付回调
     */
    public function getReceiptData($isSandbox = true){
        $result = array();
		$receipt = $_REQUEST["receipt"];
		$receiptArr = base64_decode($receipt);
		if(strpos($receiptArr,"\"environment\" = \"Sandbox\"") === false){
		    $endpoint = 'https://buy.itunes.apple.com/verifyReceipt';
		}else{
		    $endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt';
		}
		$uid = I("uid");
		$result['receipt'] =$receipt;
        $postData = json_encode( array('receipt-data' => $receipt) );
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); //这两行一定要加，不加会报SSL 错误
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $errmsg = curl_error($ch);
        curl_close($ch);

        //判断时候出错，抛出异常
        if ($errno != 0) {
            //throw new Exception($errmsg, $errno);
            $params['order_number'] = $this->make_order_number();
            $params['receipt'] = $receipt;
            $params['uid'] = $uid;
            save_IOS_buy($params);
            $this->ErrorReturn("errno:".$errno);
        }
        $data = json_decode($response);
        //判断返回的数据是否是对象
        if (!is_object($data)) {
            //throw new Exception('Invalid response data');
            $this->ErrorReturn("data is not a object");
        }
        //判断购买时候成功
        if (!isset($data->status) || $data->status != 0) {
            //throw new Exception('Invalid receipt');
            $this->ErrorReturn("status error");
        }else{
            $product_id = $data->receipt->product_id;//产品ID
            $transaction_id = $data->receipt->transaction_id;
           // $money = $data->receipt->money;
           // $num = $data->receipt->num;
            if(!empty($transaction_id)){
                $transaction = M("user_pay")->where("transaction_id={$transaction_id}")->find();
                if(empty($transaction)){
                    if(!empty($product_id)&&!empty($uid)){
                        $data = M("ios_buy")->where("product_id='{$product_id}'")->find();
                        if(!empty($data)){
                            $data['order_number'] = $this->make_order_number();
                            $data['uid'] = $uid;
                            $data['money'] = $data['money'];
                            $data['num'] = $data['num'];
                            //$data['receipt'] = $receipt;//IOS内购凭证
                            $data['transaction_id'] = $transaction_id;//IOS交易的标识，唯一
                            //添加IOS内购订单
                            update_IOS_buy($data);
                            $result['info'] = 'Success';
                            $this->SuccessReturn ( $result );
                        }else{
                            $this->ErrorReturn("select data is empty");
                        }
                    }else{
                        $this->ErrorReturn("product_id or uid is empty");
                    }
                }else{
                    $this->ErrorReturn("transaction_id is exist");
                }
            }else{
                $this->ErrorReturn("transaction_id is empty");
            }
        }
        //返回产品的信息
    }
    
    /**
     * 生成订单编号
     */
    public function make_order_number(){
        //$order_prefix = 'leader';
        $order = mktime();
        return $order;
    }
    
     /**
     *支付接口
     */
    public function ios_money(){
        $is_user=array();
        $is_user = M("ios_buy")->select();
        $result['data'] = $is_user;
        $this->SuccessReturn($result);
    }
    public function Index() {
        $data = array();
       // $scale = C('aConfig');
        $id = I('uid');//用户id
       // $id=I('get.uid');
        $num = (int)I('num');//年份
        $money = I('money');//金额
        $type = 3;//支付类型，1：支付宝支付，2：微信支付 3：银联
        if(empty($num)){
            $num=1;
        }
        $year=date('Y-',time())+$num-1;
        if(empty($id)){
            $this->ErrorReturn('用户id不能为空',0);
        }
        if(empty($money)){
            $this->ErrorReturn('支付金额不能为空',0);
        }
        $data['uid'] = $id;
        $data['cost'] = $money/100;
        $data['type'] = $type;
        $data['date'] = date('Y-m-d',time());
        $data['year_end']=$year;
        $data['limit_date'] = $year.'-12-31';
        $data ['order_number'] = date ( 'YmdHis' );
        $data ['pay_way'] = "app";

        $ress = M("user_pay")->add($data);
        if($ress){
                $unionpay_params ["orderId"] = $data ["order_number"]; // 商户订单号，8-32位数字字母，不能含“-”或“_”
                $unionpay_params ["txnTime"] = $data ["order_number"]; // 订单发送时间，格式为YYYYMMDDhhmmss
                $unionpay_params ["txnAmt"] = $money;//$data['cost']; // 交易金额，单位分
                $res = get_union_tn ( $unionpay_params );// 获取tn值
                if ($res) {
                    $result ['tn'] = $res ['tn']; // tn值
                    $result ['orderId'] = $res ['orderId']; // 订单号
                    $result ['merId'] = $res ['merId']; // 商户号
                    $result ['respCode'] = $res ['respCode']; // 应答码
                    $result ['id'] = $ress;//订单id
                    $this->SuccessReturn ( $result );
                } else {
                    $this->ErrorReturn ( '获取tn值失败', 0 );
                }
        } else {
            $this->ErrorReturn ( '下单失败', 0 );
        }
    }
    
    /**
     * 银联支付成功后回调
     */
    public function UnionNotify() {
        $aBack = $_POST;
        if (! empty ( $aBack ['signature'] )) {
            $res = unionpay_notify ( $aBack );
        } else {
            $orderId = $aBack['orderId'];
            $select_data = M ( "user_pay" )->where ( "order_number={$orderId}" )->find ();
            $params ["orderId"] = $select_data ["order_number"]; // 订单号
            $params ["txnTime"] = $select_data ["txntime"]; // 订单发送时间
            $params ["queryId"] = $select_data ["tn"]; // 流水号
            $res = unionpay_query ( $params );
        }
    }
    
    /**
     * APP 银联支付成功后，回调接口
     */
    public function AppNotify() {
        header ( 'Content-type:application/json;charset=utf-8' );//header写明Content-type
        $data = file_get_contents ( 'php://input', 'r' );//获取APP传的参数
        
        $res = validate_sign($data);//验证签名
        if($res){
            $orderId = session ( "union_order_id" );
          //  $select_data = M ( "user_pay" )->where ( "order_number={$orderId}" )->find ();
            $datas['pay_date'] = time();
            $datas['status'] = 1;
	M("user_pay")->where("order_number={$orderId}")->save($datas);
            $result ['status'] = 1;
            $result ['info'] = '签名验证成功';
            $this->SuccessReturn ( $result );
        }else{
            $this->ErrorReturn ( '签名验证失败', 0 );
        }
    }
    
    
    /**
     * 手动查询银联订单状态
     */
    public function query() {
         $id = I ( "id" );
        $params = M ( "user_pay" )->where ( "id={$id}" )->find();
        $unionpay_query_params ['orderId'] = $params ['order_number']; // 订单号
        $unionpay_query_params ["txnTime"] = $params ["order_number"]; // 被查询的交易的订单发送时间
        $unionpay_query_params ['queryId'] = $params ['queryid']; // 订单号
        $res = unionpay_query ( $unionpay_query_params );
        $result ['orderId'] = $res ['orderId']; // 订单号
        $result ['merId'] = $res ['merId']; // 商户号origRespCode
        $result ['respCode'] = $res ['respCode']; // 应答码
        $result ['origRespCode'] = $res ['origRespCode']; // 应答码
        $this->SuccessReturn ( $result );
    }
    
    
     /*
      * 成功返回
      */
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
	
}