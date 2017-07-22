<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'user-utils.php' ;




function deleteAddress($DBConnection, $UserId, $AddressId){


    $Query = "DELETE FROM `address_table` WHERE `user_id` = '$UserId' AND `address_id` = '$AddressId' " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        $ReturnArray = array(
            'status_user_delete_address' => true,
            'data' => "success"
        );
        return json_encode($ReturnArray) ;
    } else {
        $ReturnArray = array(
            'status_user_delete_address' => false,
            'error_msg' => 'Problem in deleting from the database: ' . mysqli_error($DBConnection)
        );
        return json_encode($ReturnArray) ;
    }



}


$DBConnectionBackend = YOLOSqlConnect() ;


$IncomingData = file_get_contents('php://input');
$IncomingData = json_decode($IncomingData, true) ;

$UserId = $IncomingData['user_id'] ;
$AddressId = $IncomingData['address_id'] ;

$Re = deleteAddress($DBConnectionBackend, $UserId, $AddressId) ;




echo $Re ;
//echo $IncomingData ;
