<?php
if(isset($_POST['event-send-order'])){
    $JsonText = $_POST['__json_output'] ;

    $JsonObject = json_decode($JsonText) ;

    $OrderId = $JsonObject->order_id ;
    $UserId = $JsonObject->user_id ;
    $AddressId = $JsonObject->address_id ;
    $Order_date = $JsonObject->order_date ;
    $Order_time = $JsonObject->order_time ;
    $Order_total = $JsonObject->order_total ;
    $Order_status = $JsonObject->order_status ;

    $Cartjson = $JsonObject->cart_items ;
    $StringCartJson = json_encode($Cartjson) ;
    //echo $Cartjson ;


    require_once 'sql/sqlconnection.php' ;
    $DBConnectionBackend = YOLOSqlConnect() ;
    $OrderSuccessful = 0 ;

    $Query = "INSERT INTO `order_table` VALUES ('$OrderId', '$UserId', '$AddressId', '$StringCartJson',
                    '$Order_date', '$Order_time',  '$Order_total', '$Order_status') " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;




    if($QueryResult){
        //echo "Order Placed Successfully" ;
        // do something that shows new order is received


    } else{
        echo mysqli_error($DBConnectionBackend) ;
        echo" problem in placing the order, please retry after sometime" ;
        $OrderSuccessful -- ;
    }


    foreach($Cartjson as $Record){
        $ItemId = $Record->item_id ;
        $ItemQuantity = $Record->item_quantity ;
        $Query2 = "INSERT INTO `order_items_table` VALUES ('".$OrderId."', '".$ItemId."', '".$ItemQuantity."', '".$Order_date."', '".$Order_time."' ) ";
        if(mysqli_query($DBConnectionBackend, $Query2)){

        } else{
            echo "There is some problem <br>" ;
            echo mysqli_error($DBConnectionBackend)."<br> ";
            $OrderSuccessful -- ;
        }

    }

    if($OrderSuccessful == 0){
        echo "Successfully placed order" ;
    }





}



?>