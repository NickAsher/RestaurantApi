<?php


function isEmailExists($DBConnectionFCM, $Email){
    $Query = "SELECT * FROM `tokens_table` WHERE `email` = '$Email'  " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){

        $NoOfRows = mysqli_num_rows($QueryResult) ;
        if($NoOfRows > 0){
            return true ;
        } else if ($NoOfRows == 0){
            return false ;
        }



    } else{
        echo "Error in checking whether the email exisits or not. <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }
}

function RegisterDevice($DBConnectionFCM, $Email, $Token){
    $Query = "INSERT INTO `tokens_table` VALUES ('', '$Email', '$Token') " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
//        echo "Success" ;
        return 1 ;
    } else{
        echo "Error in inserting the values to the table <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }
}



function updateToken($DBConnectionFCM, $Email, $Token){
    $Query = "UPDATE `tokens_table` SET `token` = '$Token' WHERE `email` = '$Email'   " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
//        echo "Successfully updated token" ;
        return 1 ;
    } else{
        echo "Error in updating the token in the table <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }

}


function getTokenFromEmail($DBConnectionFCM, $Email){

    $Temp = '' ;

    $Query = "SELECT * FROM `tokens_table` WHERE `email` = '$Email'   " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $Temp = $Record ;
        }
        $Token = $Temp['token'] ;
        return $Token ;

    } else {
        echo " Unable to fetch the token from the database <br>".mysqli_error($DBConnectionFCM) ;
        return "-1" ;
    }

}


function getAllToken($DBConnectionFCM){

    $TokenArray = '' ;
    $i = 0 ;

    $Query = "SELECT * FROM `tokens_table`   " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $TokenArray[$i] = $Record['token'] ;
            $i ++ ;
        }

        return $TokenArray ;

    } else {
        echo " Unable to fetch the tokens from the database <br>".mysqli_error($DBConnectionFCM) ;
        return "-1" ;
    }
}



function sendNotification($Headers, $NotificationPostFieldsArray){
    $url = "https://fcm.googleapis.com/fcm/send" ;

    $ch = curl_init();

//Setting the curl url
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($NotificationPostFieldsArray));

//finally executing the curl request
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

//Now close the connection
    curl_close($ch);

    return $result ;
}



function StoreNotificationMessageInDB($DBConnectionFCM, $Label, $Title, $Message, $Image, $Expiry, $Target, $TargetExtra, $DevicesReached){
    $Date = date("Y-m-d") ;
    $Time = date("H:i:s") ;
    $Query = "INSERT INTO `notifications_table` VALUES ('', '$Label', '$Title', '$Message', '$Image', '$Expiry',
      '$Date', '$Time', '$Target', '$TargetExtra', '$DevicesReached') ;  " ;

    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
//        echo "Successfully saved the message in the messages tab" ;
        return 1;
    } else {
        echo "Problem in saving this notification in the messages tab <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }

}







?>