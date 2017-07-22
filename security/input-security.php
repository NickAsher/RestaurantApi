<?php

class GetPostConst{
     const Post = 2 ;
    const Get = 1 ;
}


function isSecure_checkPostInput($Input){
    if(  !isset($_POST[$Input]) || empty($_POST[$Input])  ){
        die("Security errory : The input value   \$_POST['$Input']  is empty ") ;
    } else {
        return $_POST[$Input] ;
    }
}

function isSecure_checkGetInput($Input){
    if(  !isset($_GET[$Input]) || empty($_GET[$Input])  ){
        die("Security errory : The input value   \$_GET['$Input']  is empty ") ;
    } else {
        return $_GET[$Input] ;
    }
}


function isSecure_checkPostInput_String($Input){
    if(  !isset($_POST[$Input]) || (strlen($_POST[$Input]) == 0)  ){
        die("Security errory : The input value   \$_POST['$Input']  is empty ") ;
    } else {
        return $_POST[$Input] ;
    }
}

function isSecure_checkGetInput_string($Input){
    if(  !isset($_GET[$Input]) || (strlen($_GET[$Input]) == 0)  ){
        die("Security errory : The input value   \$_GET['$Input']  is empty ") ;
    } else {
        return $_GET[$Input] ;
    }
}



/* ****************************************************************************************************** */


function isSecure_IsValidPositiveDecimal($Type, $Input){
    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }

    $RegExpression = "/^\d+\.?\d+$/" ;
    if(preg_match($RegExpression, $RealInput) ){
        return $RealInput ;
    } else{
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }


}


function isSecure_isValidDecimal($Type, $Input){
    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }

    $RegExpression = "/^\-?\d+\.?\d+$/" ;
    if(preg_match($RegExpression, $RealInput) ){
        return $RealInput ;
    } else{
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }


}


function isSecure_isValidPositiveInteger($Type, $Input){

    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }


    $RegExpression = "/^\d+$/" ;
    if(preg_match($RegExpression, $RealInput) ){
        return $RealInput ;
    } else{
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }
}


function isSecure_IsValidText($Type, $Input){

    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }


    $RegExpression = "<^[\w\s\-\.\,\'\(\)\%\:\/\\\\]+$>" ;
    if(preg_match($RegExpression, $RealInput) ){
        return $RealInput ;
    } else{
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }



}



function isSecure_IsValidImageName($Type, $Input){

    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }


    $RegExpression = "/^[\w\s\-\.]+$/" ;
    if(preg_match($RegExpression, $RealInput) ){
        return $RealInput ;
    } else{
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }



}



function isSecure_IsValidItemCode($Type, $Input){

    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }


    $RegExpression = "/^[\w\s]+$/" ;
    if(preg_match($RegExpression, $RealInput) ){
        return $RealInput ;
    } else{
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }




}


function isSecure_IsYesNo($Type, $Input){

    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }


    if($RealInput == 'yes' || $RealInput == 'no'){
        return $RealInput ;
    } else {
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }
}




function isSecure_IsValidJson($Type, $Input){

    if($Type == GetPostConst::Post){
        $RealInput = isSecure_checkPostInput_String($Input) ;
    } else if ($Type == GetPostConst::Get){
        $RealInput = isSecure_checkGetInput_string($Input) ;
    } else {
        die("Unknown type") ;
    }


    if(!is_string($RealInput) || $RealInput == ''){
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }

    json_decode($RealInput) ;
    if(json_last_error() == JSON_ERROR_NONE){
        return true ;
    } else {
        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
    }
}


//
//function isSecure_isValidDate($Input){
//
//    if(Respect\Validation\Validator::date()->validate($Input)){
//      return $Input ;
//    } else {
//        die("Not a valid date $Input") ;
//    }
//
//}
//
//
//function isSecure_isValidEmail($Type, $Input){
//    if($Type == GetPostConst::Post){
//        $RealInput = isSecure_checkPostInput_String($Input) ;
//    } else if ($Type == GetPostConst::Get){
//        $RealInput = isSecure_checkGetInput_string($Input) ;
//    } else {
//        die("Unknown type") ;
//    }
//
//    if(Respect\Validation\Validator::email()->validate($RealInput)){
//        return $RealInput ;
//    } else{
//        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
//    }
//
//
//}
//
//function isSecure_isValidURL($Input){
//    return Respect\Validation\Validator::domain()->validate($Input) ;
//}
//
//
//
//function isSecure_isValidPhoneNum($Type, $Input){
//    if($Type == GetPostConst::Post){
//        $RealInput = isSecure_checkPostInput_String($Input) ;
//    } else if ($Type == GetPostConst::Get){
//        $RealInput = isSecure_checkGetInput_string($Input) ;
//    } else {
//        die("Unknown type") ;
//    }
//
//    if(Respect\Validation\Validator::phone()->validate($RealInput)){
//        return $RealInput ;
//    } else{
//        die("Security errory : The input value \$_GETPOST['$Input']  failed Backend Validation ") ;
//    }
//
//
//
//}

?>