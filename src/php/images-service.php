<?php
include "db.php";
include "cors-header.php";
class services{
    public $service_name;
    public $service_version;
    public $registry_url;
    public $registry_user;
    public $registry_token;
    public $nginx;
    public $images_number;
    public $image = array();
}
 class images{
     public $name;
     public $url;
     public $code;
 }
$service = new services(); 
//if(isset($_POST['servicename'],$_POST['serviceversion'],$_POST['repourl'],$_POST['repotoken'],$_POST['nginxconnection'])){
   //if (filter_var($_POST['repourl'],FILTER_VALIDATE_URL)) {
       # code...
       $service->service_name = $_POST['servicename'];
       $service->service_version = $_POST['serviceversion'];
       $service->registry_url = $_POST['regurl'];
       $service->registry_user = $_POST['reguser'];
       $service->registry_token = $_POST['regtoken'];
       $service->nginx = $_POST['nginx'];
       $service->images_number = $_POST['imagesnumber'];
       for ($i=0; $i < $service->images_number; $i++) { 
           # code...
           $service->image[$i]= new images();
           $service->image[$i]->name = $_POST['name'][$i];
           $service->image[$i]->url = $_POST['url'][$i];
           $service->image[$i]->code = $_POST['code'][$i];
       }
       print_r($service->nginx);

   //}
//}