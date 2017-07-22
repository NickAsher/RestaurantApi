<?php



function getAllMenuItems($DBConnectionBackend){
    $Query1 = "SELECT * FROM  `items2_table` WHERE `item_category` = 'pizza' ORDER BY `item_id` ASC  " ;
    $QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
    $PizzaArray = array() ;
    while ($Record = mysqli_fetch_assoc($QueryResult1)){
        $PizzaArray[] = $Record ;
    }

    $Query2 = "SELECT * FROM  `items2_table` WHERE `item_category` = 'burger' ORDER BY `item_id` ASC  " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    $BurgerArray = array() ;
    while ($Record = mysqli_fetch_assoc($QueryResult2)){
        $BurgerArray[] = $Record ;
    }

    $Query3 = "SELECT * FROM  `items2_table` WHERE `item_category` = 'sides' ORDER BY `item_id` ASC  " ;
    $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
    $SidesArray = array() ;
    while ($Record = mysqli_fetch_assoc($QueryResult3)){
        $SidesArray[] = $Record ;
    }

    $Query4 = "SELECT * FROM  `items2_table` WHERE `item_category` = 'drinks' ORDER BY `item_id` ASC  " ;
    $QueryResult4 = mysqli_query($DBConnectionBackend, $Query4) ;
    $DrinksArray = array() ;
    while ($Record = mysqli_fetch_assoc($QueryResult4)){
        $DrinksArray[] = $Record ;
    }

    if($QueryResult1 && $QueryResult2 && $QueryResult3 && $QueryResult4){
        $ReturnArray = array(
            'success'=>'true',
            'items'=> array (
                'pizza' => $PizzaArray,
                'burger' => $BurgerArray,
                'sides' => $SidesArray,
                'drinks' => $DrinksArray
            )
        ) ;
    } else {
        $ReturnArray = array(
            'success'=>'false',
            'error_msg'=> 'problem in fetching the item from the item table \n'.mysqli_error($DBConnectionBackend)
        ) ;
    }




    $ItemsJsonResposne = json_encode($ReturnArray) ;
    return $ItemsJsonResposne ;
}




function getOneMenuItem($DBConnectionBackend, $ItemId){

    $Query = "SELECT * FROM `items2_table` WHERE `item_id` = '$ItemId'   " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

    if($QueryResult){
        if(mysqli_num_rows($QueryResult)  == 1){
            $ReturnArray = array(
                'success'=>'true',
                'item'=>mysqli_fetch_assoc($QueryResult)
            ) ;
            return json_encode($ReturnArray) ;
        } else {
            $ReturnArray = array(
                'success'=>'false',
                'error_msg'=>"No of rows returned is not 1"
            ) ;
            return json_encode($ReturnArray) ;
        }
    } else {
        $ReturnArray = array(
            'success'=>'false',
            'error_msg'=>"Problem in fetching the item \n ".mysqli_error($DBConnectionBackend)
        ) ;
    }
    $ReturnJsonResponse = json_encode($ReturnArray) ;
    return $ReturnJsonResponse ;
}