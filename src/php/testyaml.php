<?php
include "db.php";
include "cors-header.php";
file_put_contents('C:\wamp64-2\www\saas\src\php\files.yaml', $_POST['yaml']);
$page = file_get_contents('C:\wamp64-2\www\saas\src\php\files.yaml');
$page = str_replace('-',' ', $page );
$page = str_replace('tiret','- ',$page);
$page = str_replace('"{{}}"','',$page);
$result=file_put_contents('C:\wamp64-2\www\saas\src\php\files.yaml',$page);
echo $result;