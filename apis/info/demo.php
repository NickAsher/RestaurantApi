<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils-apply-coupon.php' ;
require_once '../../utils/curl_utils.php' ;

$DBConnectionbackend = YOLOSqlConnect() ;

$LocationURL = "http://localhost/RestaurantApi/apis/coupon/apply-coupon.php" ;

$Headers = array(
    'Content-Type: application/json'
);
$DataArray = array(
    'net_price'=>500,
    'coupon_code'=>'DISC100'
) ;


$CurlOutput = makeCurlPostRequest($LocationURL, $Headers, $DataArray) ;
echo $CurlOutput ;
?>