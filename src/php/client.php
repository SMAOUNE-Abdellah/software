<?php
include "db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Content-Encoding, X-CSRF-Token, Authorization");
if ($_GET['action'] == 'addclient') {
    # code...
    $saasname = $_POST['saasname'];
    $saasmail = $_POST['saasmail'];
    $service = $_POST['service'];
    $container = $service.'-'.$saasname;
    $network = $saasname.'-net';
    $app_volume = 'app-'.$saasname.'vol';
    $db_volume = 'db-'.$saasname.'vol';
    
    //echo json_encode($data);
    $query = "INSERT INTO clients (`saasname`, `saasmail`,`service`,`container`,`network`,`appvolume`,`dbvolume`)
     VALUES ('$saasname', '$saasmail','$service','$container','$network','$app_volume','$db_volume')";
    $connexion->query($query);
}