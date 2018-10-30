<?php

// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######
// 签名证书路径
const SDK_SIGN_CERT_PATH = './ThinkPHP/Library/Btten/Payment/Unionpay/certs/unicon.pfx';

// 签名证书密码
const SDK_SIGN_CERT_PWD = '201616';

// 密码加密证书（这条一般用不到的请随便配）
const SDK_ENCRYPT_CERT_PATH = './ThinkPHP/Library/Btten/Payment/Unionpay/certs/encryptpub.cer';

// 验签证书路径（请配到文件夹，不要配到具体文件）
const SDK_VERIFY_CERT_DIR = './ThinkPHP/Library/Btten/Payment/Unionpay/certs';

// 前台请求地址
const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';

// 后台请求地址(无卡交易配置该地址)
const SDK_BACK_TRANS_URL = 'https://gateway.95516.com/gateway/api/backTransReq.do';

// 批量交易
const SDK_BATCH_TRANS_URL = 'https://gateway.95516.com/gateway/api/batchTrans.do';

//单笔查询请求地址
const SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';

//文件传输请求地址
const SDK_FILE_QUERY_URL = 'https://filedownload.95516.com/';

//有卡交易地址(仅有卡交易配置该地址)
const SDK_Card_Request_Url = 'https://gateway.95516.com/gateway/api/cardTransReq.do';

//App交易地址
const SDK_App_Request_Url = 'https://gateway.95516.com/gateway/api/appTransReq.do';

// 前台通知地址 (商户自行配置通知地址)
const SDK_FRONT_NOTIFY_URL = 'http://localhost/zsrc/api.php/Pay/UnionNotify';

// 后台通知地址 (商户自行配置通知地址，需配置外网能访问的地址)
const SDK_BACK_NOTIFY_URL = 'http://localhost/zsrc/api.php/Pay/UnionNotify';

//文件下载目录
const SDK_FILE_DOWN_PATH = './file/';

//日志 目录
const SDK_LOG_FILE_PATH = './logs/';

//日志级别，关掉的话改PhpLog::OFF
const SDK_LOG_LEVEL = PhpLog::DEBUG;




/** 以下缴费产品使用，其余产品用不到，无视即可 */
// 前台请求地址
const JF_SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/jiaofei/api/frontTransReq.do ';
// 后台请求地址
const JF_SDK_BACK_TRANS_URL = 'https://gateway.95516.com/jiaofei/api/backTransReq.do';
// 单笔查询请求地址
const JF_SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/jiaofei/api/queryTrans.do';
// 有卡交易地址
const JF_SDK_CARD_TRANS_URL = 'https://101.231.204.80:5000/jiaofei/api/cardTransReq.do';
// App交易地址
const JF_SDK_APP_TRANS_URL = 'https://gateway.95516.com/jiaofei/api/appTransReq.do';

?>