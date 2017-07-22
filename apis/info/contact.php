<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'info-utils.php' ;


$DBConnectionBackend = YOPDOSqlConnect() ;
$UserSyncNo = $_GET['__user_sync'] ;


echo getRestaurantContactInfo($UserSyncNo, $DBConnectionBackend) ;