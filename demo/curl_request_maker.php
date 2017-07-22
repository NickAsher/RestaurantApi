<?php

function makeCurlPostRequest($LocationURL, $HeadersArray, $DataArray){
    $ReturnObject = null ;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $LocationURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $HeadersArray);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($DataArray));


    $ResultJson = curl_exec($ch);


    // handling the failure of the curl request itself
    if ($ResultJson === FALSE) {
        $ReturnObject = array(
            'status'=>false,
            'error_msg'=>'Curl failed: '.curl_error($ch)
        ) ;

    } else {
        $ReturnObject = array(
            'status'=>true,
            'result'=>json_decode($ResultJson)
        ) ;

    }

    curl_close($ch);
    return json_encode($ReturnObject) ;

}


$LocationURL = "http://localhost/RestaurantApi/demo/curl_go_page.php" ;

$Headers = array(
    'Content-Type: application/json'
);
$DataArray = array(
    'order_amount'=>169,
    'coupon_code'=>'yolo'
) ;


$CurlOutput = makeCurlPostRequest($LocationURL, $Headers, $DataArray) ;
echo $CurlOutput ;











?>