<?php
include "db.php";
include "cors-header.php";
if ($_GET['action'] == 'login') {
    # code...
    $mail = $_POST['email'];
    $pass = $_POST['password'];
    $data = [];
    $j_object = array();
    function random($var){
        $string = "";
        $chaine = "a0b1c2d3e4f5g6h7i8j9klmnpqrstuvwxy123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$var; $i++){
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }
	$query = "SELECT * FROM admin WHERE email ='$mail' AND password='$pass'";
    $sql = $connexion->query($query);
    while ($rows = mysqli_fetch_assoc($sql)) {
        $data[] = $rows;
        $j_object[0] = $data;
        $j_object[1] = random(25);
        echo json_encode($j_object);
    }
}
elseif($_GET['action'] == 'signup'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "INSERT INTO admin (`username`, `email`,`password`) VALUES ('$username', '$email','$password')";
    $connexion->query($query);

}


?>