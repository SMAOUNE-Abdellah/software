<?php
include "db.php";
include "cors-header.php";
    $data = [];
	$query = "SELECT * FROM hosts ORDER BY id DESC";
    $sql = $connexion->query($query);
    while ($row = mysqli_fetch_assoc($sql)) {
        
        $data[] = $row;
        
    }
    
    

echo json_encode($data) ;
    
