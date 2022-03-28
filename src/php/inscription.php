<?php
include "db.php";
include "cors-header.php";
if ($_GET['action'] == 'login') {
    # code...
    $mail = $_POST['email'];
    $pass = $_POST['password'];
    $data = [];
	$query = "SELECT * FROM admin WHERE email ='$mail' AND password='$pass'";
    $sql = $connexion->query($query);
    while ($rows = mysqli_fetch_assoc($sql)) {
        $data[] = $rows;
    }
    echo json_encode($data);
}
elseif($_GET['action'] == 'signup'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "INSERT INTO admin (`username`, `email`,`password`) VALUES ('$username', '$email','$password')";
    $connexion->query($query);

}


?>