<?php

function YOLOSqlConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "my_database" ;

    $dbconnection = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DATABASE_NAME) ;

    if($dbconnection){
       // echo "Connected to the Database <br>" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $dbconnection ;


}

function YOLOSqlDemoConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "restaurant_analytics2" ;

    $dbconnection = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DATABASE_NAME) ;

    if($dbconnection){
        // echo "Connected to the Database <br>" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $dbconnection ;


}


function YOLOSqlEmbeddedConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "embedded" ;

    $dbconnection = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DATABASE_NAME) ;

    if($dbconnection){
        // echo "Connected to the Database <br>" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $dbconnection ;


}

function YOLOSqlFCMConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "fcm" ;

    $dbconnection = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DATABASE_NAME) ;

    if($dbconnection){
        // echo "Connected to the Database <br>" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $dbconnection ;


}



function YOLOSqlClientConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "client" ;

    $dbconnection = mysqli_connect($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DATABASE_NAME) ;

    if($dbconnection){
        // echo "Connected to the Database <br>" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $dbconnection ;


}














function YOLOSqlQuery($ConnectionObject, $TableName, $Columns, $WhereClause = null, $OrderBy = null ) {

    if($WhereClause == null && $OrderBy == null){
        $Query = "SELECT ".$Columns." FROM ".$TableName ;
        $queryResult = mysqli_query($ConnectionObject,$Query) ;

        return $queryResult ;
    }
    else if ($OrderBy == null){
        $Query = "SELECT ".$Columns." FROM ".$TableName." Where ".$WhereClause ;
        $queryResult = mysqli_query($ConnectionObject,$Query) ;

        return $queryResult ;
    }
    else if ($WhereClause == null){
        $Query = "SELECT ".$Columns." FROM ".$TableName." ORDER BY ".$OrderBy ;
        $queryResult = mysqli_query($ConnectionObject,$Query) ;

        return $queryResult ;
    }
    else{
        $Query = "SELECT ".$Columns." FROM ".$TableName." Where ".$WhereClause." ORDER BY ".$OrderBy ;
        $queryResult = mysqli_query($ConnectionObject,$Query) ;

        return $queryResult ;
    }


}



function YOLOSqlUpdate($ConnectionObject, $TableName, $ContentValuesObj, $WhereClause){
    $Query = "UPDATE `".$TableName."` SET ".$ContentValuesObj->give()." WHERE ".$WhereClause ;
    $queryResult = mysqli_query($ConnectionObject,$Query) ;
    return $queryResult ;
}

function YOLORedirect($Location){
    echo "<script type='text/javascript'> document.location = '$Location'; </script>";
}




?>