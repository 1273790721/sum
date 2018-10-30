<?php
/* *
 * 功能：手机网站支付接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "alipay.wap.create.direct.pay.by.user",
		"partner" => trim($alipay_config['partner']),
 		"seller_id" => trim($alipay_config['seller_id']),
		"payment_type"	=> '1',
		"notify_url"	=> $alipay_config['notify_url'],
		"return_url"	=> $alipay_config['return_url'],
		"out_trade_no"	=> $order_id,
		"subject"	=> $title,
		"total_fee"	=> $cash,
		"show_url"	=> $alipay_config['return_url'],
        "extern_token"	=> '',
		"_input_charset" => trim(strtolower($alipay_config['input_charset'])),
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");

echo $html_text;
