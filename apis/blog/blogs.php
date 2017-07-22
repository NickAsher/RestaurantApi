<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'blog-utils.php' ;


$DBConnectionBackend = YOPDOSqlConnect() ;





if(isset($_GET['___blog_id'])  && !empty($_GET['___blog_id']) ){
    echo getSpecificBlog2($DBConnectionBackend, $_GET['___blog_id']) ;
} else {
    $UserSyncNo = $_GET['__user_sync'] ;
    echo getAllBlogs2($UserSyncNo ,$DBConnectionBackend);


}





?>