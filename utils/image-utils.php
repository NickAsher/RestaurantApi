<?php


function isUploadedSuccessfully($ImageFileArrayVariable){
    if($ImageFileArrayVariable['error'] == 0){
//        echo "Image is successfuly placed in temp on server <br> " ;
        return true ;
    } else {
        return false ;
    }

}



function isJPEG($ImageFileArrayVariable){
    $FileVariable_Name = $ImageFileArrayVariable['name'] ;
    $Extension = explode(".", $FileVariable_Name)[1] ;

    if($Extension == 'jpg'){
//        echo "Image is a jpg file <br> ";
        return true ;
    } else {
        return false ;
    }

}



function getLastInsertedImageId($DBConnection){
    $Query = "SELECT * FROM `images_table` ORDER BY `image_id` DESC LIMIT 1 " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        $ImageId = null ;
        foreach ($QueryResult as $Record){
            $ImageId = $Record['image_id'] ;
        }
//        echo "The last inserted image id in images_table is $ImageId <br> ";
        return $ImageId ;
    } else {
        echo "Problem in retreiving the last inserted image id from images_table <br> ".mysqli_error($DBConnection) ;
        return -1 ;
    }
}



function insertImageIntoImageDatabase($DBConnection, $NewImageId, $OldImageName){
    $Query = "INSERT INTO `images_table` VALUES ('$NewImageId', '$OldImageName') " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
//        echo "Image inserted into image database <br> " ;
        return 1 ;
    } else {
        echo "problem in inserting the New image_id into the image database table <br>".mysqli_error($DBConnection) ;
        return -1 ;
    }
}






function moveImageToImageFolder($DBConnection, $ImageFolderPath_WithoutSlash, $ImageFileArrayVariable){
    /*
     * This function moves the image to the image folder
     * It performs the following checks
     *      1. Check Whether the image is uploaded Successfully or not
     *      2. Check whether the uploaded file has an .jpg extension or not.
     *
     *  It has Nine steps
     *      1. Check for successful upload of file to tmp folder
     *      2. Check whether the file has  .jpg extension or not
     *
     *      3. Get the Last Inserted Image's Id
     *      4. Add One to it, to make the New ImageId
     *      5. Pad 0's to the image Id
     *      6. Add the image with just the image id into the images database
     *      7. Add The date in front of the image id to make the new imagename
     *      8. Move the image with the new imagename to the specified image folder
     *      9. Return the imageName back.
     *
     *  If any of the steps fail, then a -1 is returned.
     *
     */

    if(!isUploadedSuccessfully($ImageFileArrayVariable)){
        echo "<br> error in uploading the image to the server <br> " ;
        return -1 ;
    }


    if(!isJPEG($ImageFileArrayVariable)){
        echo "<br> File Uploaded is not a valid Jpg Image File <br> " ;
        return -1 ;
    }

    $LastInsertedImageId = getLastInsertedImageId($DBConnection) ;
    if($LastInsertedImageId == -1){
        return -1 ;
    }

    $NextInsertImageId_Int = intval($LastInsertedImageId) + 1 ;
    $NextInsertImageId = str_pad("$NextInsertImageId_Int", 10, "0", STR_PAD_LEFT) ;

    if(insertImageIntoImageDatabase($DBConnection, $NextInsertImageId, $ImageFileArrayVariable['name']) == -1){
        return -1 ;
    }

    $NewImageName = date('Ymd')."_".$NextInsertImageId."_.jpg" ;
    $ImageFile_TmpLocation = $ImageFileArrayVariable['tmp_name'] ;


    $ResultOfMoving = move_uploaded_file($ImageFile_TmpLocation, $ImageFolderPath_WithoutSlash.'/'.$NewImageName) ;
    if($ResultOfMoving){
//        echo  "Successfuly moved the file to the image folder --> ".$ImageFileArrayVariable['name']." as $NewImageName <br>" ;
        return $NewImageName ;
    } else {
        echo "error in moving the file <br>".$ImageFileArrayVariable['name'] ;
        return -1 ;
    }






}



function deleteImageFromImageFolder($ImageFolderPath_WithoutSlash, $ImageName){

    if($ImageName == null || empty($ImageName)){
        echo "No image to delete to , image $ImageName is empty <br> ";
        return -1 ;
    }

    if(is_file($ImageFolderPath_WithoutSlash.'/'.$ImageName)){
        unlink($ImageFolderPath_WithoutSlash.'/'.$ImageName) ;
        return 1 ;
    } else {
//        echo "Problem in deleting the image file <br>".$ImageName ;
        return -1 ;
    }
}










?>