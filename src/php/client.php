<?php
include "db.php";
include "cors-header.php";
if ($_GET['action'] == 'addclient') {
    # code...
    $saasname = $_POST['saasname'];
    $saasmail = $_POST['saasmail'];
    $service = $_POST['service'];
    if(filter_var($saasmail,FILTER_VALIDATE_EMAIL)){
    $datas = [];
	$querys = "SELECT * FROM services WHERE id = '$service'";
    $sqls = $connexion->query($querys);
    while ($rows = mysqli_fetch_assoc($sqls)) {
        $datas[] = $rows;
    }
    $image = $datas[0]['image'];
    $container_app_name = $image.'-'.$saasname;
    $container_db_name = 'db-'.$image.'-'.$saasname;
    $client_network_name = $saasname.'-net';
    $client_App_volum = 'app-'.$saasname.'vol';
    $client_database_volum = 'db-'.$saasname.'vol';
    $client_domain_name = $saasname.'-'.$image.'.com';
    
    //echo json_encode($data);
    $query = "INSERT INTO customers (`saasname`, `saasmail`,`service`,`container-app`,`container-db`,`network`,`appvolume`,`dbvolume`,`domaine-name`)
     VALUES ('$saasname', '$saasmail','$image','$container_app_name','$container_db_name','$client_network_name','$client_App_volum','$client_database_volum','$client_domain_name')";
    $connexion->query($query);
    $client_network_name = escapeshellarg($client_network_name);
    $container_app_name = escapeshellarg($container_app_name);
    $container_db_name = escapeshellarg($container_db_name);
    $client_domain_name = escapeshellarg($client_domain_name);
    $client_App_volum = escapeshellarg($client_App_volum);
    $client_database_volum = escapeshellarg($client_database_volum);
    $commande="cd /etc/ansible/ && ansible-playbook secondplaybook.yml 
    -e 'client_network_name=$client_network_name container_app_name=$container_app_name
     container_db_name=$container_db_name client_domain_name=$client_domain_name
      client_App_volum=$client_App_volum client_database_volum=$client_database_volum '";
    }  
      
}
