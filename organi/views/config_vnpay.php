<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
  
$vnp_TmnCode = "9P7F376T"; //Mã định danh merchant kết nối (Terminal Id)
$vnp_HashSecret = "YTAJUOPLXQYFOZIHTZHDOYMRURPHBBIE"; //Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/project-php/organi/?option=order_success";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
