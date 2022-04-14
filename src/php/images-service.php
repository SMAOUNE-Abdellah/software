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
    public $domaine;
    public $images_number;
    public $opt_number;
    public $image = array();
}
 class images{
     public $name;
     public $url;
     public $path;
     public $backup;
     public $option = array();    
     public $ins = array();
 }
 class opt{
     public $type;
     public $key;
     public $value;
 }
 class ins{
     public $id;
    public $type;
    public $key;
    public $value; 
    public $final_value;
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

file_put_contents('/var/www/html/saas/src/php/jsondir/data.json',$service_sys);
$page = file_get_contents('/var/www/html/saas/src/php/jsondir/data.json');
$page = str_replace('\\','', $page );
$result = file_put_contents('/var/www/html/saas/src/php/jsondir/data.json',$page);

$service = new services(); 
//if(isset($_POST['servicename'],$_POST['serviceversion'],$_POST['repourl'],$_POST['repotoken'],$_POST['nginxconnection'])){
   //if (filter_var($_POST['repourl'],FILTER_VALIDATE_URL)) {
       $service->service_name = $_POST['servicename'];
       $service->service_version = $_POST['serviceversion'];
       $service->registry_url = $_POST['regurl'];
       $service->registry_user = $_POST['reguser'];
       $service->registry_token = $_POST['regtoken'];
       $service->nginx = $_POST['nginx'];
       $service->domaine = $_POST['domaine'];
       $service->images_number = $_POST['imagesnumber'];
       $service->opt_number = $_POST['optnumber'];
       $n=0;
       for ($i=0; $i < $service->images_number; $i++) { 
           $service->image[$i]= new images();
           $service->image[$i]->name = $_POST['name'][$i];
           $service->image[$i]->url = $_POST['url'][$i];
           $service->image[$i]->path = $_POST['path'][$i];
           $service->image[$i]->backup = $_POST['backup'][$i];
           $x=0;
           $z=0;
           for($j=0; $j<$_POST['optnumber']; $j++){
               if(isset($_POST['belong'][$j])){
               if ($_POST['belong'][$j] == $service->image[$i]->name) {
               # code...
                 if (isset($_POST['value'][$j])) {
                     # code...
                     $service->image[$i]->option[$x] = new opt();
                     $service->image[$i]->option[$x]->type = $_POST['type'][$j] ;
                     $service->image[$i]->option[$x]->key = $_POST['key'][$j] ;
                     $service->image[$i]->option[$x]->value = $_POST['value'][$j] ;
                      $x++;
                 }
              
                

           }
        }
        }

           for ($l=0; $l < $_POST['insnumber']; $l++) { 
            # code...
            if (isset($_POST['ins_belong'][$l])){
               if ($_POST['ins_belong'][$l] == $service->image[$i]->name){
                   $service->image[$i]->ins[$z] = new ins();
                   $service->image[$i]->ins[$z]->id = $n;
                   $service->image[$i]->ins[$z]->type = $_POST['ins_type'][$l];
                   $service->image[$i]->ins[$z]->key = $_POST['ins_key'][$l];
                   $service->image[$i]->ins[$z]->value = $_POST['ins_value'][$l];
                   $service->image[$i]->ins[$z]->final_value = null;
                   if ($_POST['ins_type'][$l] == 'SQL Request') {
                      if(!file_exists( 'SQL-Request' )){
                        mkdir('SQL-Request');
                      }
                      
                       $slash0 = '/var/www/html/saas/src/php/SQL-Request/';
                       
                      file_put_contents($slash0.$_POST['ins_key'][$l].".sql", $_POST['ins_value'][$l]);
                   }

                   $z++;
                   $n++;
            }
        }
        }

      }
      if (isset($_FILES['file'])){
          for ($n=0; $n < count($_FILES['file']['name']); $n++) { 
              # code...
              $belongto = $_POST['file_belong'][$n];
              $file_name = $_FILES['file']['name'][$n];
              $nom = $_FILES['file']['tmp_name'][$n];
              move_uploaded_file($nom, '/home'.'/'.$belongto.'/'.$file_name);
          }
        
    }
    
      $service_json = json_encode($service);
      //print_r($service_json);
     
      $query = "INSERT INTO jservice (`name`,`version`,`comp`) VALUES('$service->service_name','$service->service_version','$service_json')";
      $connexion->query($query);
      // print_r($_FILES['value']);

   //}
//}
print_r($service);
$cmmd= "sudo ansible-playbook /etc/ansible/Pullimages.yml --vault-password-file=/etc/ansible/.vault_pass";
$Pullimages=shell_exec($cmmd);
echo "<pre>";
echo $Pullimages;
echo "</pre>";
