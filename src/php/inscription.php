<?php
include "db.php";
include "cors-header.php";
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