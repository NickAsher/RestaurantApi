<?php

function makeCurlPostRequest($LocationURL, $HeadersArray, $DataArray){
    /*
     * The returned content from this function is a json string
     * with two thigns inside it. If the Curl was successfull, then the string is like this
     *      {
     *          status_curl : true,
     *          result : your_data
     *      }
     *
     * If the curl is not successfull then the string is like this
     *      {
     *          status_curl : false,
     *          error_msg : message_of_curl_error
     *      }
     */
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
            'status_curl'=>false,
            'error_msg'=>'Curl failed: '.curl_error($ch)
        ) ;

    } else {
        $ReturnObject = array(
            'status_curl'=>true,
            'result'=>json_decode($ResultJson, true)
        ) ;

    }

    curl_close($ch);
    return json_encode($ReturnObject) ;

}



function makeCurlGetRequest($LocationURL, $HeadersArray){
    /*
     * The returned content from this function is a json string
     * with two thigns inside it. If the Curl was successfull, then the string is like this
     *      {
     *          status_curl : true,
     *          result : your_data
     *      }
     *
     * If the curl is not successfull then the string is like this
     *      {
     *          status_curl : false,
     *          error_msg : message_of_curl_error
     *      }
     */
    $ReturnObject = null ;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $LocationURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $HeadersArray);

    $ResultJson = curl_exec($ch);


    // handling the failure of the curl request itself
    if ($ResultJson === FALSE) {
        $ReturnObject = array(
            'status_curl'=>false,
            'error_msg'=>'Curl failed: '.curl_error($ch)
        ) ;

    } else {
        $ReturnObject = array(
            'status_curl'=>true,
            'result'=>json_decode($ResultJson, true)
        ) ;

    }

    curl_close($ch);
    return json_encode($ReturnObject) ;
}
