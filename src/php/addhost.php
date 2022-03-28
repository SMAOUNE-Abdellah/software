<?php
include "db.php";
include "cors-header.php";
$distribution = $_POST['hostos'];
$hostuser = $_POST['hostuser'];
$hostip = $_POST['hostip'];
$hostps = $_POST['hostps'];
if (isset($distribution,$hostuser,$hostip,$hostps)) {
    # code...
   // if (filter_var($hostip,FILTER_VALIDATE_IP)) {
        # code...
        $data = [];
        $querys = "SELECT * FROM hosts WHERE ip = '$hostip'";
        $sqls = $connexion->query($querys);
        while ($rows = mysqli_fetch_assoc($sqls)) {
            $data[] = $rows;
        }
        if (empty($data)) {
            # code...
            $query = "INSERT INTO host (`name`, `ip`, `user`, `ps`) VALUES ('$distribution','$hostip','$hostuser','$hostps')" ;
            $connexion->query($query);
        }
   // }
}
echo $distribution;
