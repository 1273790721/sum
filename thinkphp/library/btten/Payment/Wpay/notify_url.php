<?php

require_once ('lib/WxPay.Config.php');
require_once ('lib/WxPay.Data.php');
require_once ('lib/WxPay.Api.php');
require_once ('lib/WxPay.Notify.php');

$notify = new Notify();
$notify->Handle();

