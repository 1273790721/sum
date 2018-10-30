<?php

require_once("lib/alipay_notify.class.php");

function pay($order_id,$title,$cash){
    require_once("alipay.config.php");

    $alipay = new AlipayNotify($alipay_config);
    
    $para = array (
        "service" => $alipay_config['service'],
        "seller_id" => $alipay_config['seller'],
        "partner" => $alipay_config['partner'],
        "notify_url" => $alipay_config['notify_url'],
        "it_b_pay" => $alipay_config['it_b_pay'],
        "sign_type" => $alipay_config['sign_type'],
        "_input_charset" => $alipay_config['input_charset'], 
        "subject" => $title,
        "body" => $title,
        "out_trade_no" => $order_id,
        "total_fee" => $cash,
        "payment_type" => 1,
    );
    //去掉sign  sign_type  type  字段
    $para_filter = paraFilter($para);
    //对参数排序
    $para_sort = argSort($para_filter);
    //拼接链接
    $para = createLinkstring($para_sort);
    
    //签名
    $private_key_path = $alipay_config['private_key_path'];
    $para_sort['sign'] = rsaSign($para, $private_key_path);
    $para_sort['sign_type'] = $alipay_config['sign_type'];
    
    //把sign和sign_type拼入链接
    $para = createLinkstring($para_sort);
    return $para;
}

