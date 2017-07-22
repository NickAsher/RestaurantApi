<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'user-utils.php' ;




function editAddress($DBConnection, $UserId, $AddressDataArray){

    $AddressId = $AddressDataArray['address_id'] ;
    $AddressName = $AddressDataArray['address_name'];
    $AddressPhone = $AddressDataArray['address_phone'];
    $AddressLine1 = $AddressDataArray['address_line1'];
    $AddressLine2 = $AddressDataArray['address_line2'];
    $AddressCity = $AddressDataArray['address_city'];
    $AddressPostal = $AddressDataArray['address_postal_code'];
    $AddressDistrict = $AddressDataArray['address_district'];
    $AddressState = $AddressDataArray['address_state'];
    $AddressCountry = $AddressDataArray['address_country'];
    $Time = date('Y-m-d H:i:s') ;



    $Query = "UPDATE `address_table`
      SET `address_name` = '$AddressName', `address_phone` = '$AddressPhone', `address_line_1` = '$AddressLine1',
      `address_line_2` = '$AddressLine2', `address_city` = '$AddressCity', `address_postal_code` = '$AddressPostal',
      `address_district` = '$AddressDistrict', `address_state` = '$AddressState', `address_country` = '$AddressCountry', `last_update` = '$Time'
      WHERE `address_id` = '$AddressId' AND `user_id` = '$UserId' " ;

    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        $ReturnArray = array(
            'status_user_edit_address' => true,
            'data' => "success"
        );
        return json_encode($ReturnArray) ;
    } else {
        $ReturnArray = array(
            'status_user_edit_address' => false,
            'error_msg' => 'Problem in updating the database: ' . mysqli_error($DBConnection)
        );
        return json_encode($ReturnArray) ;
    }



}


$DBConnectionBackend = YOLOSqlConnect() ;


$IncomingData = file_get_contents('php://input');
$IncomingData = json_decode($IncomingData, true) ;

$UserId = $IncomingData['user_id'] ;
$AddressData = $IncomingData['address_data'] ;

$Re = editAddress($DBConnectionBackend, $UserId, $AddressData) ;




echo $Re ;
//echo $IncomingData ;
