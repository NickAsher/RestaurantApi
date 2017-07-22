<?php





function getRestaurantContactInfo($UserSyncNo, $DBConnectionBackend){
    $DBSyncNo = null ;
    $Query0 = "SELECT * FROM `sync_table` WHERE `id` = '1' " ;
    try {
        $QueryResult0 = $DBConnectionBackend->query($Query0);
        $DBSyncNo = $QueryResult0->fetch(PDO::FETCH_ASSOC)['contact_sync'];


        if ($DBSyncNo == $UserSyncNo) {
            $ReturnArray = array(
                'status_contact' => 'true',
                'new_data' => "false",
            );
            return json_encode($ReturnArray);
        } else {


            $Query = "SELECT * FROM `info_contact_table` WHERE `restaurant_id` = '1'   ";

            $QueryResult = $DBConnectionBackend->query($Query);
            $ContactData = $QueryResult->fetch(PDO::FETCH_ASSOC);

            $ReturnArray = array(
                'status_contact' => 'true',
                'new_data' => 'true',
                'sync_no' => $DBSyncNo,
                'data' => $ContactData
            );
            return json_encode($ReturnArray) ;
        }
    }catch (Exception $e){
        $ReturnArray = array(
            'status_contact' => 'false',
            'error_msg' => "Problem in fetching the info " .$e
        );
        return json_encode($ReturnArray) ;
    }






}



function getRestaurantAboutusInfo2($UserSyncNo, $DBConnectionBackend){
    $DBSyncNo = null ;
    $Query0 = "SELECT * FROM `sync_table` WHERE `id` = '1' " ;
    try {
        $QueryResult0 = $DBConnectionBackend->query($Query0);
        $DBSyncNo = $QueryResult0->fetch(PDO::FETCH_ASSOC)['aboutus_sync'];


        if ($DBSyncNo == $UserSyncNo) {
            $ReturnArray = array(
                'status_aboutus' => 'true',
                'new_data' => "false",
            );
            return json_encode($ReturnArray);
        } else {


            $Query = "SELECT * FROM `info_about_table` WHERE `restaurant_id` = '1'   ";
            $QueryResult = $DBConnectionBackend->query($Query);
            $Data = $QueryResult->fetch(PDO::FETCH_ASSOC);

            $ReturnArray = array(
                'status_aboutus' => 'true',
                'new_data' => 'true',
                'sync_no' => $DBSyncNo,
                'data' => $Data
            );
            return json_encode($ReturnArray) ;
        }
    }catch (Exception $e){
        $ReturnArray = array(
            'status_aboutus' => 'false',
            'error_msg' => "Problem in fetching the info " .$e
        );
        return json_encode($ReturnArray) ;
    }






}





