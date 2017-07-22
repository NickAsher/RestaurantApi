<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;
$UserSyncNo = $_GET['__user_menu_sync'] ;



$DataArray = null;

try {


    $DBSyncNo = null ;
    $Query0 = "SELECT * FROM `sync_table` WHERE `id` = '1' " ;

    $QueryResult0 = $DBConnectionBackend->query($Query0);
    $DBSyncNo = $QueryResult0->fetch(PDO::FETCH_ASSOC)['menu_sync'];


    if ($DBSyncNo == $UserSyncNo) {
        $ReturnArray = array(
            'status_menu' => 'true',
            'new_data' => "false",
        );
        echo json_encode($ReturnArray);
    } else {

        $Query = "SELECT * FROM `menu_items_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_items_table'] = $QueryResult->fetchAll();


        $Query = "SELECT * FROM `menu_addons_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_addons_table'] = $QueryResult->fetchAll();


        $Query = "SELECT * FROM `menu_meta_category_table`  ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_meta_category_table'] = $QueryResult->fetchAll();

        $Query = "SELECT * FROM `menu_meta_subcategory_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_meta_subcategory_table'] = $QueryResult->fetchAll();

        $Query = "SELECT * FROM `menu_meta_addongroups_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_meta_addongroups_table'] = $QueryResult->fetchAll();


        $Query = "SELECT * FROM `menu_meta_size_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_meta_size_table'] = $QueryResult->fetchAll();

        $Query = "SELECT * FROM `menu_meta_rel_size_items_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_meta_rel_size_items_table'] = $QueryResult->fetchAll();


        $Query = "SELECT * FROM `menu_meta_rel_size_addons_table` ";
        $QueryResult = $DBConnectionBackend->query($Query);
        $DataArray['menu_meta_rel_size_addons_table'] = $QueryResult->fetchAll();


        $ReturnArray = array(
            'status_menu' => 'true',
            'new_data' => 'true',
            'sync_no' => $DBSyncNo,
            'data' => $DataArray
        );
        echo json_encode($ReturnArray);
    }


} catch (Exception $e){

    $ReturnArray = array(
        'status_menu' => 'false',
        'error_msg' => "Problem in fetching the info " .$e
    );
    echo json_encode($ReturnArray) ;
}
