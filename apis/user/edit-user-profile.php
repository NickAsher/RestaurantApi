<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;





function updateProfile($DBConnectionBackend, $ProfileDataArray, $IMAGE_BACKENDFRONT_FILE_PATH) {

    $ReturnArray = null ;

    $UserId = $ProfileDataArray['user_id'];
    $UserName = $ProfileDataArray['user_name'];
    $UserGender = $ProfileDataArray['user_gender'];
    $UserDOB = $ProfileDataArray['user_dob'];
    $UserEmail = $ProfileDataArray['user_email'];
    $UserMobile = $ProfileDataArray['user_mobile'];
    $UserImageUploadFlag = $ProfileDataArray['user_image_flag'];


    if (!$UserImageUploadFlag) {
        /*
         * A New image hasn't been uploaded, so we only have to update the text fields. This is very easy
         */
        $Query = "UPDATE `users_profile_table`
      SET `user_name` = '$UserName', `user_email` = '$UserEmail', `user_gender` = '$UserGender', `user_dob` = '$UserDOB', `user_phone` = '$UserMobile'
      WHERE `user_id` = '$UserId'  ";

        $QueryResult = mysqli_query($DBConnectionBackend, $Query);
        if ($QueryResult) {
            $ReturnArray = array(
                'status_user_edit_profile' => true,
                'data' => 'success'
            );

            return json_encode($ReturnArray) ;
        } else {
            $ReturnArray = array(
                'status_user_edit_profile' => true,
                'error_msg' => 'Problem in updating the database: ' . mysqli_error($DBConnectionBackend)
            );
            return json_encode($ReturnArray) ;
        }


    } else {
        /*
         * This is the case when a new image has been uploaded, so in this case
         *    1. We have to firstly query the database to get the name of the old image
         *    2. Then delete the old image from the image folder
         *    3. Add the new image to the image folder
         *    4. Update the user profile with the new fields and image_name
         */
        $OldUserImageName = null;

        //step 1
        $Query = "SELECT `user_image` FROM `users_profile_table` WHERE `user_id` = '$UserId' ";
        $QueryResult = mysqli_query($DBConnectionBackend, $Query);
        if ($QueryResult) {
            $OldUserImageName = mysqli_fetch_assoc($QueryResult)['user_image'];

        } else {
            $ReturnArray = array(
                'status_user_edit_profile' => false,
                'error_msg' => 'Problem in fetching the user info : ' . mysqli_error($DBConnectionBackend)
            );
            return json_encode($ReturnArray) ;

        }


        // step 2
        if (strlen($OldUserImageName) == 0) {
            /*
             * Image is empty, it does not exists
             */
        } else {

            if(is_file("$IMAGE_BACKENDFRONT_FILE_PATH/$OldUserImageName")){
                unlink("$IMAGE_BACKENDFRONT_FILE_PATH/$OldUserImageName") ;
            }

            else if(is_file("$IMAGE_BACKENDFRONT_FILE_PATH/$OldUserImageName") and !is_writable("$IMAGE_BACKENDFRONT_FILE_PATH/$OldUserImageName")){
                $ReturnArray = array(
                    'status_user_edit_profile' => false,
                    'error_msg' => 'Problem in deleting the old image: file exists and is not writeable'
                );
                return json_encode($ReturnArray) ;
            } else {
                // file does not exist, so do nothing
            }





        }


        //step 3
        $UserImageString = $ProfileDataArray['user_image_string'];
        $NewUserImageName = $UserId."_" . time() . ".jpg";
        $ImageDirectory = "$IMAGE_BACKENDFRONT_FILE_PATH/" ;

        if(!is_dir($ImageDirectory) or !is_writable($ImageDirectory)){
            $ReturnArray = array(
                'status_user_edit_profile' => false,
                'error_msg' => 'Problem in writing the new image : Directory does not exist or is not writeable'
            );
            return json_encode($ReturnArray) ;
        }

        $Success = file_put_contents($ImageDirectory.$NewUserImageName, base64_decode($UserImageString));
        if($Success === false){
            $ReturnArray = array(
                'status_user_edit_profile' => false,
                'error_msg' => 'Problem in decoding the new image : ' . mysqli_error($DBConnectionBackend)
            );
            return json_encode($ReturnArray) ;
        }


        // step 4
        $Query = "UPDATE `users_profile_table`
      SET `user_name` = '$UserName', `user_email` = '$UserEmail', `user_gender` = '$UserGender', `user_dob` = '$UserDOB', `user_phone` = '$UserMobile', `user_image` = '$NewUserImageName'
      WHERE `user_id` = '$UserId'  ";

        $QueryResult = mysqli_query($DBConnectionBackend, $Query);
        if ($QueryResult) {
            $ReturnArray = array(
                'status_user_edit_profile' => true,
                'data' => 'success'
            );
            return json_encode($ReturnArray) ;

        } else {
            $ReturnArray = array(
                'status_user_edit_profile' => false,
                'error_msg' => 'Problem in updating the database: ' . mysqli_error($DBConnectionBackend)
            );
            return json_encode($ReturnArray) ;

        }


    }

}



$DBConnectionBackend = YOLOSqlConnect() ;
$ReturnArray = null;


$ProfileData = file_get_contents('php://input');
$ProfileData = json_decode($ProfileData, true) ;

$Re = updateProfile($DBConnectionBackend, $ProfileData, $IMAGE_USER_BACKENDFRONT_FILE_PATH) ;




echo $Re ;












