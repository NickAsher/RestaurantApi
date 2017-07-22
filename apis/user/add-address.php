<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'user-utils.php' ;




function addAddress($DBConnection, $UserId, $AddressDataArray){

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


    $Query = "INSERT INTO `address_table` VALUES ('', '$UserId', '$AddressName', '$AddressPhone', '$AddressLine1', '$AddressLine2',
      '$AddressCity', '$AddressPostal', '$AddressDistrict', '$AddressState', '$AddressCountry', '$Time' ) " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        $ReturnArray = array(
            'status_user_add_address' => true,
            'error_msg' => "success"
        );
        return json_encode($ReturnArray) ;
    } else {
        $ReturnArray = array(
            'status_user_add_profile' => false,
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

$Re = addAddress($DBConnectionBackend, $UserId, $AddressData) ;




echo $Re ;
//echo $IncomingData ;
