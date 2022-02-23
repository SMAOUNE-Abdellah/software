<?php
include "db.php";
include "cors-header.php";
if(isset($_POST['servicename'],$_POST['serviceurl'],$_POST['serviceversion'])){
        if(filter_var($_POST['serviceurl'],FILTER_VALIDATE_URL)){
            $servicename = $_POST['servicename'];
            $serviceversion = $_POST['serviceversion'];
            $serviceurl = $_POST['serviceurl'];
            $servicesql = $_FILES['file'];
            $image = $servicename.':'.$serviceversion;
            $data = [];
            $querys = "SELECT * FROM hosts WHERE nom = '$servicename' AND version = '$serviceversion'";
            $sqls = $connexion->query($querys);
            while ($rows = mysqli_fetch_assoc($sqls)) {
            $data[] = $rows;
            }
            if (empty($data)) {
            # code...
            $query = "INSERT INTO services (`nom`, `version`, `url`, `image`) VALUES ('$servicename','$serviceversion','$serviceurl','$image')'" ;
            $connexion->query($query);
            }
            
        }
    }