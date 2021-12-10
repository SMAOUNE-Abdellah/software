<?php
include "db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Content-Encoding, X-CSRF-Token, Authorization");
if ($_GET['action'] == 'login') {
    # code...
    $data = [];
	$query = "SELECT * FROM admin";
    $sql = $connexion->query($query);
    while ($rows = mysqli_fetch_assoc($sql)) {
        $data[] = $rows;
    }
    echo json_encode($data);
}
elseif($_GET['action'] == 'signup'){
    $username = $_POST['username'];
    $email = $_POST['emails'];
    $password = $_POST['passwords'];
    $query = "INSERT INTO admin (`username`, `email`,`password`) VALUES ('$username', '$email','$password')";
    $connexion->query($query);

}


?>