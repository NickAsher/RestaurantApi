<?php


$PostOutput = $_POST ;
$arr = array(
   'name'=>$_SERVER['DOCUMENT_ROOT']
) ;
//$post = fopen('php://input', 'r');
//$data = json_decode(stream_get_contents($post));
//fclose($post);

$json = file_get_contents('php://input');
//$values = json_decode($json, true);




echo($json) ;













