<?php

require_once ('lib/WxPay.Config.php');
require_once ('lib/WxPay.Data.php');
require_once ('lib/WxPay.Api.php');

function pay($order_id,$title,$cash){
    
    //商品金额,单位为分
    $cash = $cash * 100;
    
    $inputObj = new WxPayUnifiedOrder();
    $inputObj->SetOut_trade_no($order_id);
    $inputObj->SetBody($title);
    $inputObj->SetTotal_fee($cash);
    $inputObj->SetTrade_type(WxPayConfig::TRADE_TYPE);
    
    //统一下单
    $result = WxPayApi::unifiedOrder($inputObj);
    
    $result['timestamp'] = time();
    $result['wxpackage'] = 'Sign=WXPay';
    
//     $xml = sign($result);
    $result['sign'] = sign($result);
    return $result;
}

function sign($data){
    $input = new WxPayUnifiedOrder();
    $input->SetAppid(WxPayConfig::APPID);
    $input->SetPartnerid(WxPayConfig::MCHID);
    $input->SetPrepayid($data['prepay_id']);
    $input->SetPackage('Sign=WXPay');
    $input->SetNoncestr($data['nonce_str']);
    $input->SetTimestamp(time());
    
    $sing = $input->GetValues();
    //签名
    return $input->SetSign();
}


















