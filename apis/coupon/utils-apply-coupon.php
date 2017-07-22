<?php



class CouponResult implements JsonSerializable{
    private $Status ;
    private $NotificationMessage ;

    private $CartDetails ;
    private $CouponDetails ;

    function __construct() {
        $this->CartDetails = new stdClass() ;
        $this->CouponDetails = new stdClass() ;
    }



    function setStatus($Status){
        $this->Status = $Status ;
    }

    function setNotificationMessage($msg){
        $this->NotificationMessage = $msg ;
    }



    function setData_CartDetails($OriginalOrderAmount, $CouponDiscount){
        $NewOrderAmount = $OriginalOrderAmount - $CouponDiscount ;

        $this->CartDetails->OrigianlOrderAmount = $OriginalOrderAmount ;
        $this->CartDetails->CouponDiscount = $CouponDiscount ;
        $this->CartDetails->NewOrderAmount = $NewOrderAmount ;

    }

    function setData_CouponDetails($CouponCode, $ShortMessage){
        $this->CouponDetails->CouponCode = $CouponCode ;
        $this->CouponDetails->ShortMessage = $ShortMessage ;

    }





    function jsonSerialize() {
        /*
         * This functions needs to return an array so that the result can be encoded in json
         */
        if($this->Status == false) {
            return[
                'status'=>false,
                'notf_msg'=>$this->NotificationMessage
            ] ;
        } else {
            return[
                'status'=>true,
                'notf_msg'=>$this->NotificationMessage,
                'cart_details'=>array(
                    'original_order_amt'=>$this->CartDetails->OrigianlOrderAmount,
                    'coupon_discount'=>$this->CartDetails->CouponDiscount,
                    'new_net_price'=>$this->CartDetails->NewOrderAmount
                ),
                'coupon_details'=>array(
                    'coupon_code'=>$this->CouponDetails->CouponCode,
                    'coupon_msg'=>$this->CouponDetails->ShortMessage
                )
            ] ;
        }

    }
}







function isCouponValid($DBConnectionBackend, $CouponCode){
    /*
     * This function checks whether the coupon code is valid or not.
     * It does not check whether the coupon active or not.
     *
     * If the coupon exists, it return the Coupon in Coupon array object
     * If the Coupon does not Exists, it return 0
     * If there is database error, then it return -1 ;
     */

    $Query = "SELECT * FROM `coupon_coupons_discount_table` WHERE `name` = '$CouponCode' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        if(mysqli_num_rows($QueryResult) == 1){
//            echo "Coupon code exists <br> " ;
            return mysqli_fetch_assoc($QueryResult) ;
        } else {
            //echo " coupon is invalid" ;
            return 0 ;
        }

    } else {
//        echo "Problem in fetching the coupon <br>".mysqli_error($DBConnectionBackend) ;
        return -1 ;
    }
}












function isCouponActive($CouponArrayObject){
    if($CouponArrayObject['active'] == 1) {
        return true ;
    } else {
        return false ;
    }
}




function getCouponErrorMessage($CouponArrayObject){
    return 'This coupon is expired' ;
}

function isCouponExpired($CouponArrayObject){
    $CurrentTimestamp = date('Y-m-d H:i:s') ;
    $ExpiryTimestamp = $CouponArrayObject['expiry_timestamp'] ;

    if( strtotime($CurrentTimestamp) < strtotime($ExpiryTimestamp) ){
        return false ;
    } else {
        return true ;
    }
}



function isOrderPasses_MinBillAmount($OrderAmount, $MinBillAmount){
    if($OrderAmount >= $MinBillAmount){
        return true;
    } else{
        return false ;
    }
}


/* **************************************** Cart Discount Functions ************************************************* */






function isCouponValid_CartDiscount($DBConnectionBackend, $CouponCode){
    /*
     * This function checks whether the coupon code is valid or not.
     * It does not check whether the coupon active or not.
     * If the coupon exists, it return the Coupon in Coupon array object
     */
    $Temp = null ;
    $Query = "SELECT * FROM `coupon_coupons_discount_table` WHERE `name` = '$CouponCode' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        if(mysqli_num_rows($QueryResult) == 1){
//            echo "Coupon code exists <br> " ;
            foreach ($QueryResult as $Record){
                $Temp = $Record ;
            }
            return $Temp ;
        } else {
            //echo " coupon is invalid" ;
            return 0 ;
        }

    } else {
        echo "Problem in fetching the coupon <br>".mysqli_error($DBConnectionBackend) ;
        return -1 ;
    }
}








/* *********************************************  */

function isFreeItemsInTheCart($CartItemsArray, $FreeItemsArray){
    /*
     * This function checks whether the free items that are offered are present in the cart or not
     * So it Returns a boolean .
     *
     * The working of this function is like this.
     * Firstly to understand it's working, we have to understand in what form are we going to get input data.
     * So we have two things,
     *      CartItemsArray : This is basically the list of items in the cart
     *      FreeItemsArray : These are the items that we have to check whether they are in the cart or not
     *
     * The structure of CartItemsArray is like this
     *      '[
                [
                    "item_id":43007,
                    "item_quantity":3,
                    "item_size_code":"normal",
                    "item_addon":"addon_data_1"
                ],
                [
                    "item_id":44005,
                    "item_quantity":2,
                    "item_size_code":"medium",
                    "item_addon":""
                ],
                [
                    "item_id":41002,
                    "item_quantity":3,
                    "item_size_code":"small",
                    "item_addon":""
                ],
                [
                    "item_id":41002,
                    "item_quantity":2,
                    "item_size_code":"medium",
                    "item_addon":"addon_data_2"
                ]
            ]'
     *
     * So here we have 4 fields. Remember that no two items will be same
     * In the FreeItemsArray, each item will only have 3 fields the quantity field is not there
     * So in the FreeItemsArray, things might be replicated. This is easier to make.
     * Strucutre of FreeItemsArray
     *      [
                ]
                    "item_id":41002,
                    "item_size_code": "small",
                    "item_addon":""
                ],
                [
                    "item_id":41002,
                    "item_size_code": "small",
                    "item_addon":""
                ]
            ]
     *
     *
     * So here we can see that we have two same items in the FreeItemsArray.
     * Now the way that we are going to check whether the items in FreeItems are there in the CartItemsArray is this
     *
     * Firstly we are going to convert each item in both the arrays into a simplified string.
     * The string version of an item is   "item_id"-"item_size_code"-"item_addon"
     * So an item like following
     *          [
                    "item_id":41008,
                    "item_size_code": "normal",
                    "item_addon":"some_data"
                ]
     *  is converted into     "41008-normal-some_data"
     *
     * And if an item has multiple quantities, it will be converted into multiple items like these.
     * So Our original CartItemsArray will now look like this.
     *
     *      "43007-normal-addon_data_1"
     *      "43007-normal-addon_data_1"
     *      "43007-normal-addon_data_1"
     *      "44005-medium-"
     *      "44005-medium-"
     *      "41002-small-"
     *      "41002-small-"
     *      "41002-small-"
     *      "41002-medium-addon_data_3"
     *      "41002-medium-addon_data_3"
     *
     * This is a much simplified version as it is a simple array instead of being an associative array.
     * But this has more items.
     * Similarly our Simplified FreeItemsArray will look like
     *
     *      "41002-small-"
     *      "41002-small-"
     *
     * Now we have two arrays of strings, and we have to see how many items in them match.
     * Although we can simply use the function array_intersect, which compares the intersection of two arrays, that function fails on duplicate values
     * So what we are going to do is this
     *
     * Remember that we can't delete an element from array
     *
     * We will have a MatchCounter = 0
     * In the outer loop we will iterate over Simplified FreeItemsArray {
     *      In the inner loop we will iterate over Simplified CartItemsArray {
     *          If FreeItemElement == CartItemElement {
     *              set CartItemElement = "EMPTY" ;
     *              MatchCounter++ ;
     *              break inner loop ; so we can iterate over next item of outer loop
     *          }
     *      }
     * }
     *
     *
     * See that whenever we get a match, we set that element to a string called "EMPTY".
     * This is done, so that another element of the FreeItemsArray don't get matched to that again. So duplicacy is removed
     *
     * Now if the MatchCounter == total elements if Simplified FreeItemsArray, then return true else false
     * Since FreeItemsArray does not have a item_quantity setting so count(SimplifiedFreeItemsArray) and count(FreeItemsArray) is same .
     *
     *
     *
     */

    $TotalFreeItems = count($FreeItemsArray) ;
    $MatchCounter = 0 ;
    $Simplified_CartItemsArray = array() ;
    $Simplified_FreeItemsArray = array() ;




    foreach ($CartItemsArray as $CartItem){
        $ItemQuantity = $CartItem['item_quantity'] ;
        for($i=1;$i<=$ItemQuantity;$i++){
            $Simplified_CartItemsArray[] = $CartItem['item_id']."-".$CartItem['item_size_code']."-".json_encode($CartItem['item_addon']) ;
        }
    }






    foreach ($FreeItemsArray as $FreeItem){
        $Simplified_FreeItemsArray[] = $FreeItem['item_id']."-".$FreeItem['item_size_code']."-".json_encode($FreeItem['item_addon']) ;
    }




    // remember that we have to change the value of cartItem to EMPTY.
    // but when we iterate over an array in foreach loop, we can't change it.
    // to do that we have to pass value by reference.
    // We can do that by using '&' symbol after the 'as' in foreach

    // foreach($VarArray as &$VarName){

    foreach ($Simplified_FreeItemsArray as $Simplified_FreeItem_String){
        foreach ($Simplified_CartItemsArray as &$Simplified_CartItem_String){
            if($Simplified_FreeItem_String == $Simplified_CartItem_String){
                $Simplified_CartItem_String = "Empty" ;
                $MatchCounter ++ ;
                break ;
            }

        }
    }


    if($MatchCounter == $TotalFreeItems){
        return true ;
    } else {
        return false ;
    }




}



function getPriceOfFreeProducts($DBConnection, $FreeItemsArray)
{
    /*
     * In this method, we are going to get the price of free items
     * So to do that, we have to get the price of each item
     *
     */
    $TotalPrice = 0;

    foreach ($FreeItemsArray as $FreeItem) {
        $ItemId = $FreeItem['item_id'];
        $ItemSizeCode = $FreeItem['item_size_code'];
        $Query = "SELECT * FROM `menu_meta_rel_size-items_table` WHERE `item_id` = '$ItemId' AND `size_code` = '$ItemSizeCode' ";
        $QueryResult = mysqli_query($DBConnection, $Query);
        if(!$QueryResult){
            return -1 ;
        }
        $Record = mysqli_fetch_assoc($QueryResult);
        $TotalPrice += floatval($Record['item_price']);
    }

    return $TotalPrice ;

}







function applyDiscount2_CartDiscountMoney($OrderAmount, $CouponArrayObject){
    $DiscountAmount = floatval($CouponArrayObject['value']) ;

    $AfterCouponObject = new CouponResult() ;
    $AfterCouponObject->setStatus(true) ;
    $AfterCouponObject->setNotificationMessage($CouponArrayObject['long_notf_msg']) ;
    $AfterCouponObject->setData_CartDetails($OrderAmount, $DiscountAmount) ;
    $AfterCouponObject->setData_CouponDetails($CouponArrayObject['name'], $CouponArrayObject['short_notf_msg']) ;
    return $AfterCouponObject ;
}




function applyDiscount2_CartDiscountPercentage($OrderAmount, $CouponArrayObject){
    $DiscountPercentage = floatval($CouponArrayObject['value']) ;

    $DiscountAmount = ($DiscountPercentage * $OrderAmount)/100 ;
    $MaxDiscountAllowed = floatval($CouponArrayObject['max_discount_amt']) ;
    /*
     * Check whether there is a limit on max discount that can be applied
     */
    if($MaxDiscountAllowed == 0){
        // this means unlimited discount
    } else {
        $DiscountAmount = min($DiscountAmount, $MaxDiscountAllowed) ;

    }


    $AfterCouponObject = new CouponResult() ;
    $AfterCouponObject->setStatus(true) ;
    $AfterCouponObject->setNotificationMessage($CouponArrayObject['long_notf_msg']) ;
    $AfterCouponObject->setData_CartDetails($OrderAmount, $DiscountAmount) ;
    $AfterCouponObject->setData_CouponDetails($CouponArrayObject['name'], $CouponArrayObject['short_notf_msg']) ;
    return $AfterCouponObject ;


}


function applyDiscount_ManyProductFreeOnMinBill($DBConnection, $CouponArrayObject, $CartJsonArray, $OrderAmount){
    /*
     * We need to do this
     *
     * Check If All of the free products are in the cart.
     * Then dynamically calculate the price of products in coupon
     * Check if the min bill is there without the price of free products. OrderAmount-PriceOfFreeProducts
     *
     * If all these is done, then simply reduce the Price of free products from the OrderAmount
     * The price of free products will be called as coupon discount
     *
     *
     *
     */

    $AfterCouponObject = new CouponResult() ;


    $FreeitemsArray = json_decode($CouponArrayObject['value_text'], true) ;


    try{


    $isFreeItemsInTheCart = isFreeItemsInTheCart($CartJsonArray, $FreeitemsArray) ;
    if(!$isFreeItemsInTheCart){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Please add the free items in the cart also ") ;
        return $AfterCouponObject ;
    }
    } catch (Exception $e){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Error: ".$e->getMessage()) ;
        return $AfterCouponObject ;
    }

//    $AfterCouponObject->setStatus(true) ;
//    $AfterCouponObject->setNotificationMessage("Yolo its right") ;
//    $AfterCouponObject->setData_CartDetails(400, 200) ;
//    $AfterCouponObject->setData_CouponDetails("BURGFREE", "yolo applied") ;
//    return $AfterCouponObject ;



    $ValueOfFreeProducts = getPriceOfFreeProducts($DBConnection, $FreeitemsArray) ;
    if($ValueOfFreeProducts == -1){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Database Connection Error: $ValueOfFreeProducts") ;
        return $AfterCouponObject ;
    }


    $TotalOrderMinusFreeProductValue = $OrderAmount - $ValueOfFreeProducts ;
    if(!isOrderPasses_MinBillAmount($TotalOrderMinusFreeProductValue, $CouponArrayObject['min_bill_amt'])){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Order must contain min value of ".$CouponArrayObject['min_bill_amt']." without free items") ;
        return $AfterCouponObject ;
    }

    $AfterCouponObject->setStatus(true) ;
    $AfterCouponObject->setNotificationMessage($CouponArrayObject['long_notf_msg']) ;
    $AfterCouponObject->setData_CartDetails($OrderAmount, $ValueOfFreeProducts) ;
    $AfterCouponObject->setData_CouponDetails($CouponArrayObject['name'], $CouponArrayObject['short_notf_msg']) ;
    return $AfterCouponObject ;







}















function applyCoupon($DBConnection, $OrderAmount, $CouponCode, $CartDetails){


    $AfterCouponObject  = new CouponResult() ;



    $CouponArrayObject = isCouponValid($DBConnection, $CouponCode) ;
    if($CouponArrayObject == 0){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("The Coupon does not exist") ;
        return $AfterCouponObject ;
    } else if($CouponArrayObject == -1){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Problem in connecting to coupon database") ;
        return $AfterCouponObject ;
    }



    if(isCouponActive($CouponArrayObject) == false){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("This coupon is expired") ;
        return $AfterCouponObject;
    }



    if(isOrderPasses_MinBillAmount($OrderAmount, $CouponArrayObject['min_bill_amt']) == false){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Invalid Use : There should be a min bill of".$CouponArrayObject['min_bill_amt']) ;
        return $AfterCouponObject;
    }







    $CouponType = $CouponArrayObject['type'] ;
    switch ($CouponType){
        case 'CART_DISC_PERC' :
            $AfterCouponObject = applyDiscount2_CartDiscountPercentage($OrderAmount, $CouponArrayObject) ;
            break ;
        case 'CART_DISC_MON' :
            $AfterCouponObject = applyDiscount2_CartDiscountMoney($OrderAmount, $CouponArrayObject) ;
            break ;
        case 'FREE_PRODUCT_MIN_BILL' :
            $AfterCouponObject =  applyDiscount_ManyProductFreeOnMinBill($DBConnection, $CouponArrayObject, $CartDetails, $OrderAmount) ;


    }

    return $AfterCouponObject ;









}



?>