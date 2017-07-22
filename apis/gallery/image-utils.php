<?php



function getAllGalleryItems2($UserSyncNo, $DBConnectionBackend){
    $DBSyncNo = null ;
    $Query0 = "SELECT * FROM `sync_table` WHERE `id` = '1' " ;
    try {
        $QueryResult0 = $DBConnectionBackend->query($Query0);
        $DBSyncNo = $QueryResult0->fetch(PDO::FETCH_ASSOC)['gallery_sync'];


        if ($DBSyncNo == $UserSyncNo) {
            $ReturnArray = array(
                'status_gallery' => 'true',
                'new_data' => "false",
            );
            return json_encode($ReturnArray);
        } else {


            $Query = "SELECT * FROM  `gallery_table` ORDER BY `gallery_item_sr_no` ASC  " ;
            $QueryResult = $DBConnectionBackend->query($Query);
            $Data = $QueryResult->fetchAll();

            $ReturnArray = array(
                'status_gallery' => 'true',
                'new_data' => 'true',
                'sync_no' => $DBSyncNo,
                'data' => $Data
            );
            return json_encode($ReturnArray) ;
        }
    }catch (Exception $e){
        $ReturnArray = array(
            'status_gallery' => 'false',
            'error_msg' => "Problem in fetching the info " .$e
        );
        return json_encode($ReturnArray, JSON_UNESCAPED_SLASHES) ;
    }






}





function getSpecificGalleryItem($DBConnectionBackend, $GalleryItemId){
    $Query = "SELECT * FROM  `gallery_table`  WHERE `gallery_item_id` = :item_id  " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute(['item_id' => $GalleryItemId]);
        $ReturnArray = array(
            'status_gallery' => 'true',
            'data' => $QueryResult->fetch(PDO::FETCH_ASSOC)
        );
    } catch (Exception $e) {
        $ReturnArray = array(
            'status_gallery'=>'false',
            'error_msg'=>"Problem in fetching the gallery-item \n ".$e
        ) ;
    }

    return json_encode($ReturnArray) ;





}




?>