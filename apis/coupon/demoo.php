<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils-apply-coupon.php' ;
require_once '../../utils/curl_utils.php' ;

$DBConnectionbackend = YOLOSqlConnect() ;

$LocationURL = "http://localhost/RestaurantApi/apis/coupon/apply-coupon-2.php" ;

$Headers = array(
    'Content-Type: application/json'
);
$DataArray = array(
    'net_price'=>1500,
    'coupon_code'=>'BURGFREE',
    'cart' =>array(
        array(
            'item_id'=>42001,
            'item_size_code'=>'normal',
            'item_quantity'=>2,
            'item_addon'=>''
        ),
        array(
            'item_id'=>42002,
            'item_size_code'=>'normal',
            'item_quantity'=>2,
            'item_addon'=>''
        ),
        array(
            'item_id'=>41004,
            'item_size_code'=>'medium',
            'item_quantity'=>1,
            'item_addon'=>''
        ),
        array(
            'item_id'=>41005,
            'item_size_code'=>'small',
            'item_quantity'=>1,
            'item_addon'=>''
        )
    )
) ;

//echo json_encode($DataArray );


$CurlOutput = makeCurlPostRequest($LocationURL, $Headers, $DataArray) ;
echo $CurlOutput ;
?>