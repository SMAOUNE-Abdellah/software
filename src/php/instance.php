<?php
include "db.php";
include "cors-header.php";

$img = [];
$opt = [[]];

for ($i=0; $i < count($_POST['image']); $i++) { 
    # code...
    $img[] = (array)json_decode($_POST['image'][$i]);
    for ($j=0; $j < count($img[$i]['option']); $j++) { 
        # code...
        $opt[$i][$j] = (array)$img[$i]['option'][$j];
         
    }
}

class Env{
    public $key;
    public $value;
}
class App{
  public $image;
  public $container_name;
  public $restart;
  public $environement = array();
  public $volumes = array();
  public $networks = array();
}

class Services{
    public $app = array();
}

class Saas{
    public $version;
    public $services= array();
    public $volumes = array();
    public $networks = array();
}
// $tiret est une var pour adapter le fichier yaml
$tiret ='tiret';
$saas = array();

$saas['version'] = "1.2";
for ($k=0; $k < count($img); $k++) { 
    # code...
    $y = 0;
    //$saas->services[$k][$_POST['saasname']."_".$img[$k]['name']] = new App();
    $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['image'] = $img[$k]['url'];
    $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['container_name'] = $_POST['saasname']."_".$img[$k]['name'];
    $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['restart'] = 'always';
    $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['volumes'][$y] = $tiret.$_POST['saasname']."_".$img[$k]['name']."_"."volume".":".$img[$k]['path'];
    $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['networks'][$y] =$tiret.$_POST['saasname']."_"."networks";
    $saas['volumes'][$_POST['saasname']."_".$img[$k]['name']."_"."volume"] = '{{}}';
    $x=0;
    for ($l=0; $l < count($opt[$k]); $l++) { 
        # code...
        
       // $saas->services->app[$k]->environement[$l] = new Env();
       // $saas->services->app[$k]->environement[$l]->key = $opt[$k][$l]['key'];
        if ($opt[$k][$l]['type'] == 'Variable Static') {
            # code..
            $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['environment'][$l][$opt[$k][$l]['key']] = $opt[$k][$l]['value'];
            //$saas->services->app[$k]->environement[$l]->value = $opt[$k][$l]['value'];
        }
        else if ($opt[$k][$l]['type'] == 'Variable Dynamique'){
           // $saas->services->app[$k]->environement[$l]->value = $_POST['saasname']."_".$img[$k]['name'];
           $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['environment'][$l][$opt[$k][$l]['key']] = $_POST['saasname']."_".$img[$k]['name'];
        }
        else if($opt[$k][$l]['type'] == 'Variable Du00e9pendante'){
           // $saas->services->app[$k]->environement[$l]->value = $_POST['dep_opt_value'][$x];
           $saas['services'][$k][$_POST['saasname']."_".$img[$k]['name']]['environment'][$l][$opt[$k][$l]['key']] = $_POST['dep_opt_value'][$x];
            $x++;
        }
        
        

    }
}
$saas['networks'][$_POST['saasname']."_"."networks"] = '{{}}';

$my = json_encode($saas);
$client = $_POST['saasname'];
$query = "INSERT INTO jclient (`name`,`comp`) VALUES('$client','$my')";
$connexion->query($query);
$data = [];

$query2 = "SELECT * FROM jclient WHERE name = '$client'";
$sql2 = $connexion->query($query2);
while ($row = mysqli_fetch_assoc($sql2)) {
    
    $data[] = $row;
    
    
    
}

echo json_encode($data) ;

