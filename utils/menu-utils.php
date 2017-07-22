<?php



function getListOfAllCategories_Array($DBConnection){
    $AllCategoriesArray = array() ;
    $Query1 =  "SELECT * FROM `menu_meta_category_table` ORDER BY `category_id` ASC" ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;

    if($QueryResult1){
        $i = 0 ;
        foreach ($QueryResult1 as $Record){
            $AllCategoriesArray[$i] = $Record ;
            $i++ ;
        }
    } else {
        die("Unable to fetch the Item categories from the menu_meta_category_table <br> ".mysqli_error($DBConnection)) ;
    }
    return $AllCategoriesArray ;
}





function getSingleCategoryInfoArray($DBConnection, $CategoryCode){
    /*
     * This function returns the Information of a single category like its code, its name, its size variation
     * If it is unable to fetch the info, then it will kill the page
     */

    $SingleCategoryInfoArray = null ;

    $Query1 =  "SELECT * FROM `menu_meta_category_table` WHERE `category_code` = '$CategoryCode' " ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    $NumOfRows = mysqli_num_rows($QueryResult1) ;
    if($NumOfRows != 1){
        die("No of rows returned from category table is not 1 <br> ".mysqli_error($DBConnection)) ;
    }

    if($QueryResult1){
        $SingleCategoryInfoArray = mysqli_fetch_assoc($QueryResult1) ;
    } else {
        die("Unable to fetch the category info from the menu_meta_category_table <br> ".mysqli_error($DBConnection)) ;
    }

    return $SingleCategoryInfoArray ;
}









function getListOfAllSubCategory_InACategory_Array($DBConnection, $CategoryCode){
    /*
     * This function returns all the rows of subacategory of a particular category.
     * For example, if the category code is pizza, then it will return three subcategory rows like
     *  1.   pizza   simple_pizza   Simple Pizza  2   5
     *  2.   pizza   signature_pizza   Signature Pizza   3   5
     *
     */

    $CategorySubCategoriesListArray = array() ;

    $Query1 =  "SELECT * FROM `menu_meta_rel_category-subcategory_table`
                  WHERE `category_code` = '$CategoryCode' ORDER BY `subcategory_sr_no` ASC" ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;

    if($QueryResult1){
        $i = 0 ;
        foreach ($QueryResult1 as $Record){
            $CategorySubCategoriesListArray[$i] = $Record ;
            $i++ ;
        }
    } else {
        die("Unable to fetch the SubCategory list from the menu_meta_rel_category :  <br> ".mysqli_error($DBConnection)) ;
    }


    return $CategorySubCategoriesListArray ;

}



function getSingleSubCategoryInfoArray($DBConnection, $SubCategoryRelId){

    $SingleSubCategoryInfoArray = null ;

    $Query1 = "SELECT * FROM `menu_meta_rel_category-subcategory_table`
                WHERE `rel_id` = '$SubCategoryRelId'  " ;
//    echo $Query1 ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    $NumOfRows = mysqli_num_rows($QueryResult1) ;
    if($NumOfRows != 1){
        die("SubCategory not Found") ;
    }


    if($QueryResult1){
        $SingleSubCategoryInfoArray = mysqli_fetch_assoc($QueryResult1) ;
    } else {
        die("Unable to fetch the subcategory info from the menu_meta_rel_category-subcategory_table <br> ".mysqli_error($DBConnection)) ;
    }

    return $SingleSubCategoryInfoArray ;

}






function getListOfAllAddonGroupsInACategory_Array($DBConnection, $CategoryCode){
    $CategoryAddonGroupsListArray = array() ;
    $Query1 =  "SELECT * FROM `menu_meta_rel_category-addon_table`
                WHERE `category_code` = '$CategoryCode' ORDER BY `addon_group_sr_no` ASC" ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;

    if($QueryResult1){
        $i = 0 ;
        foreach ($QueryResult1 as $Record){
            $CategoryAddonGroupsListArray[$i] = $Record ;
            $i++ ;
        }
    } else {
        die("Unable to fetch the Addons Group list from the menu_meta_rel_category-addon_table :<br> ".mysqli_error($DBConnection)) ;
    }
    return $CategoryAddonGroupsListArray ;
}



function getSingleAddonGroupInfoArray($DBConnection, $AddonGroupRelId){
    /*
     *
     *
     */
    $Query1 = "SELECT * FROM `menu_meta_rel_category-addon_table` WHERE `rel_id` = '$AddonGroupRelId' " ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    $NumOfRows = mysqli_num_rows($QueryResult1) ;
    if($NumOfRows != 1){
        die("Addon-Group not Found") ;
    }

    if($QueryResult1){
        $SingleAddonGroupInfoArray = mysqli_fetch_assoc($QueryResult1) ;
    } else {
        die("Unable to fetch the Addon-Group info from the menu_meta_rel_category-addon_table <br> ".mysqli_error($DBConnection)) ;
    }

    return $SingleAddonGroupInfoArray ;


}



function getListOfAllAddonItemsInAddonGroup_Array($DBConnection, $CategoryCode, $AddonGroupRelId){

    /*
     *
     */

    $AddonItemsInGroupArray = array() ;

    $Query1 = "SELECT * FROM `menu_addons_table`
                WHERE `item_category_code` = '$CategoryCode' AND `item_addon_group_rel_id` = '$AddonGroupRelId'
                ORDER BY `item_id` " ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    if($QueryResult1){
        $i = 0 ;
        foreach ($QueryResult1 as $Record){
            $AddonItemsInGroupArray[$i] = $Record ;
            $i++ ;
        }
    } else {
        die("Unable to fetch the Addons Item from the menu_addon_table :<br> ".mysqli_error($DBConnection)) ;
    }
    return $AddonItemsInGroupArray ;



}



function getSingleAddonItemInfoArray($DBConnection, $CategoryCode, $AddonItemId){

    /*
     *
     */

    $SingleAddonItemInfoArray = null ;

    $Query1 = "SELECT * FROM `menu_addons_table`
                WHERE `item_category_code` = '$CategoryCode' AND `item_id` = '$AddonItemId' " ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    $NumOfRows = mysqli_num_rows($QueryResult1) ;
    if($NumOfRows != 1){
        die("Addon-Item not Found") ;
    }

    if($QueryResult1){
        $SingleAddonItemInfoArray = mysqli_fetch_assoc($QueryResult1) ;
    } else {
        die("Unable to fetch the Addon-Item info from the menu_addon_table <br> ".mysqli_error($DBConnection)) ;
    }

    return $SingleAddonItemInfoArray ;

}



function getListOfAllSizesInCategory($DBConnection, $CategoryCode){
    $ListOfAllSizesInCategory = array();

    $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode' ORDER BY `size_sr_no` ";
    $QueryResult = mysqli_query($DBConnection, $Query);

    if ($QueryResult) {
        $i = 0;
        foreach ($QueryResult as $Record) {
            $ListOfAllSizesInCategory[$i] = $Record;
            $i++;
        }
    } else {
        die("Unable to fetch the Sizes for the category $CategoryCode :<br> " . mysqli_error($DBConnection));
    }

    return $ListOfAllSizesInCategory ;
}



function getListOfAllMenuItemsInCategory_Array($DBConnection, $CategoryCode) {
    $ListOfMenuItemsInCategory = array();

    $Query = "SELECT * FROM `menu_items_table` WHERE `item_category_code` = '$CategoryCode' ORDER BY `item_id` ";
    $QueryResult = mysqli_query($DBConnection, $Query);

    if ($QueryResult) {
        $i = 0;
        foreach ($QueryResult as $Record) {
            $ListOfMenuItemsInCategory[$i] = $Record;
            $i++;
        }
    } else {
        die("Unable to fetch the Menu Item for the category $CategoryCode :<br> " . mysqli_error($DBConnection));
    }

    return $ListOfMenuItemsInCategory ;

}



function getListOfAllMenuItemsInSubCategory_Array($DBConnection, $SubCategoryRelId){
    $ListOfMenuItemsInSubCategory = array();

    $Query = "SELECT * FROM `menu_items_table` WHERE `item_subcategory_rel_id` = '$SubCategoryRelId' ORDER BY `item_id` ";
    $QueryResult = mysqli_query($DBConnection, $Query);

    if ($QueryResult) {
        $i = 0;
        foreach ($QueryResult as $Record) {
            $ListOfMenuItemsInSubCategory[$i] = $Record;
            $i++;
        }
    } else {
        die("Unable to fetch the Menu Item for the Subcategory $SubCategoryRelId :<br> " . mysqli_error($DBConnection));
    }

    return $ListOfMenuItemsInSubCategory ;

}

function getSingleMenuItemInfoArray($DBConnection, $MenuItemId){
    $SingleMenuItemInfoArray = null ;

    $Query1 = "SELECT * FROM `menu_items_table` WHERE `item_id` = '$MenuItemId' " ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    $NumOfRows = mysqli_num_rows($QueryResult1) ;
    if($NumOfRows != 1){
        die("Menu-Item not Found") ;
    }

    if($QueryResult1){
        $SingleMenuItemInfoArray = mysqli_fetch_assoc($QueryResult1) ;
    } else {
        die("Unable to fetch the Menu-Item info from the menu_items_table <br> ".mysqli_error($DBConnection)) ;
    }

    $CategoryName = getSingleCategoryInfoArray($DBConnection, $SingleMenuItemInfoArray['item_category_code'])['category_display_name'] ;
    $SubCategoryName = getSingleSubCategoryInfoArray($DBConnection, $SingleMenuItemInfoArray['item_subcategory_rel_id']) ['subcategory_display_name'] ;
    $SingleMenuItemInfoArray['category_display_name'] = $CategoryName ;
    $SingleMenuItemInfoArray['subcategory_display_name'] = $SubCategoryName ;

    return $SingleMenuItemInfoArray ;
}


function getSingleMenuItemInfoView_Array($DBConnection, $MenuItemId){
    $SingleMenuItemInfoArray = null ;

    $Query1 = "SELECT * FROM `menu_items_view` WHERE `item_id` = '$MenuItemId' " ;
    $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
    $NumOfRows = mysqli_num_rows($QueryResult1) ;
    if($NumOfRows != 1){
        die("Menu-Item not Found") ;
    }

    if($QueryResult1){
        $SingleMenuItemInfoArray = mysqli_fetch_assoc($QueryResult1) ;
    } else {
        die("Unable to fetch the Menu-Item info from the menu_items_view <br> ".mysqli_error($DBConnection)) ;
    }

    return $SingleMenuItemInfoArray ;
}






?>