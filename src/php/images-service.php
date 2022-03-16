<?php
include "db.php";
include "cors-header.php";
class Ser {
    public $url;
    public $username;
    public $password;
    public $image = array();
}
class Img {
    public $url_image;
}
class services{
    public $service_name;
    public $service_version;
    public $registry_url;
    public $registry_user;
    public $registry_token;
    public $nginx;
    public $images_number;
    public $opt_number;
    public $image = array();
}
 class images{
     public $name;
     public $url;
     public $path;
     public $option = array();    
 }
 class opt{
     public $type;
     public $key;
     public $value;
 }
$ser = new Ser();
$ser->url = $_POST['regurl'];
$ser->username =  $_POST['reguser'];
$ser->password =  $_POST['regtoken'];
for($a = 0; $a < $_POST['imagesnumber']; $a++){
    $ser->image[$a] = new Img();
    $ser->image[$a]->url_image = $_POST['url'][$a];
}
$service_sys = json_encode($ser);
$service = new services(); 
//if(isset($_POST['servicename'],$_POST['serviceversion'],$_POST['repourl'],$_POST['repotoken'],$_POST['nginxconnection'])){
   //if (filter_var($_POST['repourl'],FILTER_VALIDATE_URL)) {
       $service->service_name = $_POST['servicename'];
       $service->service_version = $_POST['serviceversion'];
       $service->registry_url = $_POST['regurl'];
       $service->registry_user = $_POST['reguser'];
       $service->registry_token = $_POST['regtoken'];
       $service->nginx = $_POST['nginx'];
       $service->images_number = $_POST['imagesnumber'];
       $service->opt_number = $_POST['optnumber'];
       for ($i=0; $i < $service->images_number; $i++) { 
           $service->image[$i]= new images();
           $service->image[$i]->name = $_POST['name'][$i];
           $service->image[$i]->url = $_POST['url'][$i];
           $service->image[$i]->path = $_POST['path'][$i];
           $x=0;
           for($j=0; $j<$_POST['optnumber']; $j++){
               if ($_POST['belong'][$j] == $service->image[$i]->name) {
               # code...
               $service->image[$i]->option[$x] = new opt();
               $service->image[$i]->option[$x]->type = $_POST['type'][$j] ;
               $service->image[$i]->option[$x]->key = $_POST['key'][$j] ;
               //if (isset($_FILES['value'][$j])) {
                   # code...
                   //$service->image[$i]->option[$j]->value = $_FILES['value'][$j] ;

              // }
                  // else
                $service->image[$i]->option[$x]->value = $_POST['value'][$j] ;
                $x++;

           }
        }

      }
    
      $service_json = json_encode($service);
      //print_r($service_json);
     
      $query = "INSERT INTO jservice (`name`,`version`,`comp`) VALUES('$service->service_name','$service->service_version','$service_json')";
      $connexion->query($query);
      // print_r($_FILES['value']);

   //}
//}
print_r($service_sys);