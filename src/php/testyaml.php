<?php
include "db.php";
include "cors-header.php";
$nginx_connexion = $_POST['nginx'];
if ($_POST['nginx'] != 'network') {
    # code...
    $container_related_name = $_POST['client'].substr($_POST['nginx'],0,-4);

}
else $container_related_name = null;
$client_network = $_POST['client'].'networks';
file_put_contents('C:\wamp64-2\www\saas\src\php\\'.$_POST['client'].'.yaml', $_POST['yaml']);
$page = file_get_contents('C:\wamp64-2\www\saas\src\php\\'.$_POST['client'].'.yaml');
$page = str_replace('-',' ', $page );
$page = str_replace('tiret','- ',$page);
$page = str_replace('space','-',$page);
$page = str_replace('"{{}}"','',$page);
$result=file_put_contents('C:\wamp64-2\www\saas\src\php\\'.$_POST['client'].'.yaml',$page);
echo $container_related_name;