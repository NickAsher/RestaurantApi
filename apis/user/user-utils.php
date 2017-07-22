<?php



function getUserPastOrders($DBConnection, $UserId){
    $Query = "SELECT * FROM `order_table` WHERE `user_id` = '$UserId' " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;

    $ReturnArray = null ;
    if($QueryResult) {
        $OrdersArray = array() ;
        $i = 0;
        foreach ($QueryResult as $Record) {
            $OrdersArray[$i]['order_id'] = $Record['order_id'] ;
            $OrdersArray[$i]['order_no'] = $Record['order_no'] ;
            $OrdersArray[$i]['order_date'] = $Record['order_date'] ;
            $OrdersArray[$i]['order_time'] = $Record['order_time'] ;
            $OrdersArray[$i]['order_total'] = $Record['order_total'] ;
            $OrdersArray[$i]['order_total_quantity'] = $Record['order_total_quantity'] ;
            $OrdersArray[$i]['order_description'] = $Record['cart'] ;


            $i++;



        }

        $ReturnArray = array(
            'status_user_orders'=>true,
            'data'=>$OrdersArray
        ) ;

    } else {
        $ReturnArray = array(
            'status_user_orders'=>false,
            'data'=>"error in fetching the user information ".mysqli_error($DBConnection)
        ) ;
    }

    return json_encode($ReturnArray) ;





}




function getUserInfoAndAddress($DBConnection, $UserId){
    $ReturnArray = null ;
    $UserArray = null ;
    $AddressArray = null ;

    $Query = "SELECT * FROM `users_profile_table` WHERE `user_id` = '$UserId' " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;

    $ReturnArray = null ;
    if($QueryResult){


        if(mysqli_num_rows($QueryResult) == 0){
            $ReturnArray = array(
                'status_user_info_address'=>false,
                'error_msg'=>"No such user exists  "
            ) ;
            return json_encode($ReturnArray) ;
        }
        $Record = mysqli_fetch_assoc($QueryResult) ;



        $Query2 = "SELECT * FROM `address_table` WHERE  `user_id` = '$UserId' " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;

        if($QueryResult2){
            $i = 0 ;
            foreach($QueryResult2 as $Record2){

                $AddressArray[$i]['address_id'] = $Record2['address_id'] ;
                $AddressArray[$i]['address_name'] = $Record2['address_name'] ;
                $AddressArray[$i]['address_phone'] = $Record2['address_phone'] ;
                $AddressArray[$i]['address_line1'] = $Record2['address_line_1'] ;
                $AddressArray[$i]['address_line2'] = $Record2['address_line_2'] ;
                $AddressArray[$i]['address_postal_code'] = $Record2['address_postal_code'] ;
                $AddressArray[$i]['address_city'] = $Record2['address_city'] ;
                $AddressArray[$i]['address_district'] = $Record2['address_district'] ;
                $AddressArray[$i]['address_state'] = $Record2['address_state'] ;
                $AddressArray[$i]['address_country'] = $Record2['address_country'] ;

                $i++ ;
            }




        } else {
            $ReturnArray = array(
                'status_user_info_address'=>false,
                'data'=>"error in fetching the address information from address_table : <br> ".mysqli_error($DBConnection)
            ) ;
            return json_encode($ReturnArray) ;
        }



        $UserArray['user_name'] = $Record['user_name'] ;
        $UserArray['user_gender'] = $Record['user_gender'] ;
        $UserArray['user_dob'] = $Record['user_dob'] ;
        $UserArray['user_email'] = $Record['user_email'] ;
        $UserArray['user_phone'] = $Record['user_phone'] ;
        $UserArray['user_image_link'] = $Record['user_image'] ;
        $UserArray['user_no_of_addresses'] = $i ;
        $UserArray['user_addresses'] = $AddressArray ;




        $ReturnArray = array(
            'status_user_info_address'=>true,
            'data'=>$UserArray
        ) ;

    } else {
        $ReturnArray = array(
            'status_user_info_address'=>false,
            'data'=>"error in fetching the user information ".mysqli_error($DBConnection)
        ) ;
    }

    return json_encode($ReturnArray) ;
}
