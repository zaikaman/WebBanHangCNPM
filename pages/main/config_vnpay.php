<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Load config and environment variables
require_once '../../admincp/config/config.php';

// Get VNPay configuration from environment variables
$vnpay_config = vnpay_config();
$vnp_TmnCode = $vnpay_config['tmn_code']; //Mã định danh merchant kết nối (Terminal Id)
$vnp_HashSecret = $vnpay_config['hash_secret']; //Secret key
$vnp_Url = $vnpay_config['url'];

// Get app URL from environment for return URL
$app_url = app_url();
$vnp_Returnurl = $app_url . "/index.php?quanly=camon";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";

//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
