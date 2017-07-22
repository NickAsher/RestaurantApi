<?php


function YOPDOSqlConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "my_database" ;

    $DSN = "mysql:host=$MYSQL_HOST;dbname=$MYSQL_DATABASE_NAME;port=3306;charset=utf8" ;

    $opt2 = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $opt = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $PdoConnection = new PDO($DSN, $MYSQL_USERNAME, $MYSQL_PASSWORD, $opt2) ;


    if($PdoConnection){
//        echo "Connected to database" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $PdoConnection ;


}


function YOPDOSqlFCMConnect(){
    $MYSQL_HOST = "localhost" ;
    $MYSQL_USERNAME = "yolo2" ;
    $MYSQL_PASSWORD = "yoloyolo" ;
    $MYSQL_DATABASE_NAME = "fcm" ;

    $DSN = "mysql:host=$MYSQL_HOST;dbname=$MYSQL_DATABASE_NAME;port=3306;charset=utf8" ;

    $opt2 = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $opt = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $PdoConnection = new PDO($DSN, $MYSQL_USERNAME, $MYSQL_PASSWORD, $opt2) ;


    if($PdoConnection){
//        echo "Connected to database" ;
    } else {
        die("Error in connecting to the database <br>") ;
    }


    return $PdoConnection ;


}

