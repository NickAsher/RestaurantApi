<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils-apply-coupon.php' ;


$DBConnectionBackend = YOLOSqlConnect() ;


$CartAndCouponJsonData = file_get_contents('php://input');



$CartAndCouponJsonData = json_decode($CartAndCouponJsonData, true) ;


$NetPrice = $CartAndCouponJsonData['net_price'] ;
$CouponCode = $CartAndCouponJsonData['coupon_code'] ;
$CartArray = $CartAndCouponJsonData['cart'] ;



//
//
//
//echo json_encode(array(
//    'item_id'=>'yolo'
//)) ;


$ReturnObject = applyCoupon($DBConnectionBackend, floatval($NetPrice), $CouponCode, $CartArray) ;
echo json_encode($ReturnObject) ;












