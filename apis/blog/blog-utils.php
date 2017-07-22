<?php



function getAllBlogs2($UserSyncNo, $DBConnectionBackend){
    $DBSyncNo = null ;
    $Query0 = "SELECT * FROM `sync_table` WHERE `id` = '1' " ;
    try {
        $QueryResult0 = $DBConnectionBackend->query($Query0);
        $DBSyncNo = $QueryResult0->fetch(PDO::FETCH_ASSOC)['blog_sync'];


        if ($DBSyncNo == $UserSyncNo) {
            $ReturnArray = array(
                'status_blogs' => 'true',
                'new_data' => "false",
            );
            return json_encode($ReturnArray);
        } else {


            $Query = "SELECT `blog_id`, `blog_creation_date`, `blog_title`, `blog_display_image` FROM  `blogs_table`  ORDER BY `blog_creation_date` DESC  " ;
            $QueryResult = $DBConnectionBackend->query($Query);
            $Data = $QueryResult->fetchAll();

            $ReturnArray = array(
                'status_blogs' => 'true',
                'new_data' => 'true',
                'sync_no' => $DBSyncNo,
                'data' => $Data
            );
            return json_encode($ReturnArray, JSON_UNESCAPED_SLASHES) ;
        }
    }catch (Exception $e){
        $ReturnArray = array(
            'status_blogs' => 'false',
            'error_msg' => "Problem in fetching the info " .$e
        );
        return json_encode($ReturnArray, JSON_UNESCAPED_SLASHES) ;
    }






}





function getSpecificBlog2( $DBConnectionBackend, $BlogId){
    $DBSyncNo = null ;
    try {

        $Query = "SELECT * FROM  `blogs_table`  WHERE `blog_id` = :blog_id  " ;
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute(['blog_id'=>$BlogId]) ;
        $Data = $QueryResult->fetch(PDO::FETCH_ASSOC);

        $ReturnArray = array(
            'status_blogs' => 'true',
            'data' => $Data
        );
        return json_encode($ReturnArray, JSON_UNESCAPED_SLASHES) ;

    }catch (Exception $e){
        $ReturnArray = array(
            'status_blogs' => 'false',
            'error_msg' => "Problem in fetching the info " .$e
        );
        return json_encode($ReturnArray, JSON_UNESCAPED_SLASHES) ;
    }






}





?>