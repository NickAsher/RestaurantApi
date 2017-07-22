<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'image-utils.php' ;


$DBConnectionBackend = YOPDOSqlConnect() ;
$UserSyncNo = $_GET['__user_sync'] ;






    echo getAllGalleryItems2($UserSyncNo, $DBConnectionBackend) ;



?>