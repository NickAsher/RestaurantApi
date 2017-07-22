<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$ReturnArray = null ;
$ListOfAllCategories = getListOfAllCategories_Array($DBConnectionBackend) ;

$ReturnArray['success'] = true ;
$ReturnArray['no_of_categories'] = count($ListOfAllCategories) ;
$i = 0 ;

foreach ($ListOfAllCategories as $Record){
//    $ReturnArray['categories'][$i] = $Record ;
    $ReturnArray['categories'][$i]['category_code'] = $Record['category_code'] ;
    $ReturnArray['categories'][$i]['category_display_name'] = $Record['category_display_name'] ;

    $ListOfAllSubCategoriesInCategory = getListOfAllSubCategory_InACategory_Array($DBConnectionBackend, $Record['category_code']) ;
    $ReturnArray['categories'][$i]['category_no_of_subcategories'] = count($ListOfAllSubCategoriesInCategory) ;



    $j = 0 ;
    foreach ($ListOfAllSubCategoriesInCategory as $Record2){
        $ReturnArray['categories'][$i]['category_subcategory_data'][$j]['subcategory_rel_id'] = $Record2['rel_id'] ;
        $ReturnArray['categories'][$i]['category_subcategory_data'][$j]['subcategory_display_name'] = $Record2['subcategory_display_name'] ;

        $ListOfAllMenuItemsInSubCategory = getListOfAllMenuItemsInSubCategory_Array($DBConnectionBackend, $Record2['rel_id']) ;
        $ReturnArray['categories'][$i]['category_subcategory_data'][$j]['subcategory_no_of_menuitems'] = count($ListOfAllMenuItemsInSubCategory) ;



        $k = 0 ;
        foreach ($ListOfAllMenuItemsInSubCategory as $Record3){
            $ReturnArray['categories'][$i]['category_subcategory_data'][$j]['subcategory_items_data'][$k] = $Record3 ;

            $k++ ;
        }


        $j++ ;
    }






    $i ++ ;
}

echo json_encode($ReturnArray) ;



?>