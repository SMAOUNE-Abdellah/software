<?php
include "db.php";
include "cors-header.php";

class options{
    public $type;
    public $key;
    public $val;

}

$service = $_POST['service'];
/*
$query = "SELECT comp->'$.images_number' FROM jservice WHERE name='$service'";
$sql = $connexion->query($query);
while ($row = mysqli_fetch_assoc($sql)) {
    
    $data1 = $row;
    
}
$query1 = "SELECT comp->'$.opt_number' FROM jservice WHERE name='$service'";
$sql1 = $connexion->query($query1);
while ($row1 = mysqli_fetch_assoc($sql1)) {
    
    $data2 = $row1;
    
}
for ($i=0; $i < $data1; $i++) { 
    # code...
    for ($j=0; $j < $data2; $j++) { 
        # code...
        $query2 = "SELECT comp->'$.image[$i].option[$j].type' FROM jservice WHERE name='$service'";
        $sql2 = $connexion->query($query2);
        $table []= $sql2;
        //json_decode($datum);
       
    }
    

}
//echo json_encode($data);
echo $$table;

*/

$data = [];

$query2 = "SELECT * FROM jservice WHERE name = '$service'";
$sql2 = $connexion->query($query2);
while ($row = mysqli_fetch_assoc($sql2)) {
    
    $data[] = $row;
    
    
    
}

echo json_encode($data) ;