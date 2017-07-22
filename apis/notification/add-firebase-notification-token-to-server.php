<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once 'notification_utils.php';









if(  isset($_POST['token']) && isset($_POST['email'])   ){
    if(  !empty($_POST['token'])  && !empty($_POST['email'])  ){

        $Token = $_POST['token'] ;
        $Email = $_POST['email'] ;

        $DBConnectionFCM = YOLOSqlFCMConnect() ;

        if( isEmailExists($DBConnectionFCM, $Email) ){
            $Return  = updateToken($DBConnectionFCM, $Email, $Token) ;
            if($Return == 1){
                echo "Updated" ;
            }else {
                echo "problem in updating the token" ;
            }
        } else {
            $Return = RegisterDevice($DBConnectionFCM, $Email, $Token) ;
            if($Return == 1){
                echo "Registered" ;
            } else{
                echo "problem in registering the device" ;
            }
        }





    }
}

?>
