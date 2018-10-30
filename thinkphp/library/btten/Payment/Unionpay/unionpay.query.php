<?php
/**
 * 重要：联调测试时请仔细阅读注释！
 *
 * 产品：跳转网关支付产品<br>
 * 交易：交易状态查询交易：只有同步应答 <br>
 * 日期： 2015-09<br>
 * 版本： 1.0.0
 * 版权： 中国银联<br>
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能及规范性等方面的保障<br>
 * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》，<br>
 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
 *                             测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
 *                           2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
 * 交易说明： 1）对前台交易发起交易状态查询：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
 *        2）对后台交易发起交易状态查询：后台类资金类交易同步返回00，成功银联有后台通知，商户也可以发起 查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
 *        					         后台类资金类同步返03 04 05响应码及未得到银联响应（读超时）需发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
 */
//以下信息非特殊情况不需要改动

//默认商户号仅作为联调测试使用，正式上线还请使用正式申请的商户号
$unionpay_query_params["merId"]        = '898420148160627';

//版本号
$unionpay_query_params['version']      = '5.0.0';

//编码方式
$unionpay_query_params['encoding']     = 'utf-8';

//交易类型
$unionpay_query_params['txnType']      = '00';

//交易子类
$unionpay_query_params['txnSubType']   = '00';

//业务类型
$unionpay_query_params['bizType']      = '000000';

//签名方法
$unionpay_query_params['signMethod']   = '01';

//渠道类型，07-PC，08-手机
$unionpay_query_params['channelType']  = '08';

//接入类型
$unionpay_query_params['accessType']   = '0';

//TODO 以下信息需要填写
//$unionpay_query_params['merId'] = $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
//$unionpay_query_params['orderId'] = $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
//$unionpay_query_params['txnTime'] = $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
//$unionpay_query_params['txnAmt'] = $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
//$unionpay_query_params['reqReserved'] ='透传信息',      //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据

//TODO 其他特殊用法请查看 special_use_purchase.php
?>