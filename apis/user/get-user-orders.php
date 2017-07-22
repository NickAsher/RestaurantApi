<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'user-utils.php' ;


$DBConnectionBackend = YOLOSqlConnect() ;



$UserId = isSecure_checkGetInput('__user_id') ;
echo getUserPastOrders($DBConnectionBackend, $UserId) ;




?>