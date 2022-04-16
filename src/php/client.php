<?php
include "db.php";
include "cors-header.php";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
if (isset($fname,$lname,$email)) {
    # code...
   
        $data = [];
        $querys = "SELECT * FROM clients WHERE fname = '$fname' AND lname = '$lname'";
        $sqls = $connexion->query($querys);
        while ($rows = mysqli_fetch_assoc($sqls)) {
            $data[] = $rows;
        }
        if (empty($data)) {
            # code...
            $query = "INSERT INTO clients (`fname`, `lname`, `email`) VALUES ('$fname','$lname','$email')" ;
            $connexion->query($query);
            echo $fname;
        }

        
   
}

