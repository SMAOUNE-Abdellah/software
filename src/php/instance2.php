<?php
include "db.php";
include "cors-header.php";

$img = [];
$option = [[]];
$var = [[]];

for ($i=0; $i < count($_POST['image']); $i++) { 
    # code...
    $img[] = (array)json_decode($_POST['image'][$i]);
    for ($j=0; $j < count($img[$i]['option']); $j++) { 
        # code...
        $option[$i][$j] = (array)$img[$i]['option'][$j];
         
    }
    for ($s=0; $s < count($img[$i]['ins']); $s++) { 
        # code...
        $var[$i][$s] = (array)$img[$i]['ins'][$s];
    }
}

// $tiret est une var pour adapter le fichier yaml
$tiret ='tiret';
$saas = array();

$saas['version'] = "2.2";
$x=0;
$a=0;

for ($k=0; $k < count($img); $k++) { 
    # code...
    $y = 0;
    //$saas->services[$k][$_POST['saasname']."_".$img[$k]['name']] = new App();
    $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['image'] = $img[$k]['url'];
    $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['container_name'] = $_POST['saasname']."_".substr($img[$k]['name'],0,-4);
    $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['restart'] = 'always';
    $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['volumes'][] = $tiret.$_POST['saasname']."_".substr($img[$k]['name'],0,-4)."_"."volume".":".$img[$k]['path'];
    $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['networks'][$y] =$tiret.$_POST['saasname']."_"."networks";
    $saas['volumes'][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)."_"."volume"] = '{{}}';

     if ($img[$k]['name'] == $_POST['domaine']) {
        # code...
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][]['VIRTUAL_HOST'] =  $_POST['saasname'].'service.com';
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][]['LETSENCRYPT_HOST'] = $_POST['saasname'].'service.com';
        //$saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][]['LETSENCRYPT_MAIL'] = 'abdellahsmaoune@gmail.com';

    }

    if(isset($var[$k])){
    for ($l=0; $l < count($var[$k]); $l++) { 
        # code...
        
       // $saas->services->app[$k]->environement[$l] = new Env();
       // $saas->services->app[$k]->environement[$l]->key = $opt[$k][$l]['key'];
        if ($var[$k][$l]['type'] == 'Variable ENV') {
            # code..
            $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][][$var[$k][$l]['key']] = $_POST['ins_var_fvalue'][$x];
            //$saas->services->app[$k]->environement[$l]->value = $opt[$k][$l]['value'];
            $x++;
        }
        else if ($var[$k][$l]['type'] == 'SQL Request'){
            $request = file_get_contents('/var/www/html/saas/src/php/SQL-Request/'.$var[$k][$l]['key'].'.sql');
            $request = str_replace('aaa',$_POST['ins_sql_fvalue'][$a], $request );
            
            $result=file_put_contents('/home/sql_directory/'.$var[$k][$l]['key'].'_final'.'.sql',$request);
            $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['volumes'][] = 'tiret'.'/home/sql_directory'.str_replace('-','space','/:/docker-entrypoint-initdb.d/');
           // $saas['volumes']['/home/sql_directory/'] = '{{}}';

            $a++;
        }
        else if($var[$k][$l]['type'] == 'File'){
             if (isset($_FILES['ins_file_fvalue'])){
                 
            for ($n=0; $n < count($_FILES['ins_file_fvalue']['name']); $n++) { 
              # code...
              $file_name = '/home/directory/'.$_FILES['ins_file_fvalue']['name'][$n];
              $nom = $_FILES['ins_file_fvalue']['tmp_name'][$n];
              move_uploaded_file($nom, $file_name);
              $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['volumes'][] = 'tiret'.'/home/directory/';
              //$saas['volumes'][$_POST['saasname'].'_dir'] = '{{}}';
          }
        
    }
            
        }
        
    }

    }
    if (isset($option[$k])){
    for ($c=0; $c < count($option[$k]); $c++) { 
        # code...
        if ($option[$k][$c]['type'] == 'Variable Static') {
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][][$option[$k][$c]['key']] = $option[$k][$c]['value'];
    }
    else if ($option[$k][$c]['type'] == 'Variable Dynamique'){
        // $saas->services->app[$k]->environement[$l]->value = $_POST['saasname']."_".$img[$k]['name'];
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][][$option[$k][$c]['key']] = $_POST['saasname'].'_'.substr($option[$k][$c]['value'],0,-4);
     }
    }
    }

    if (is_dir('/home'.'/'.$img[$k]['name'])) {
        # code...
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['volumes'][] = $tiret.'/home'.'/'.$img[$k]['name'];


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

// Create the json file for the client that contain information about backup.
$info = array();
for ($s=0; $s < count($img); $s++) { 
    # code...
    $info[$s]['container_name'] = $_POST['saasname']."_".substr($img[$s]['name'],0,-4);
    $info[$s]['backup_path'] = $img[$s]['backup'];
}
$json_info = json_encode($info);
file_put_contents('/var/www/html/saas/jsonclients/'.$_POST['saasname'].'.json',$json_info);
$page = file_get_contents('/var/www/html/saas/jsonclients/'.$_POST['saasname'].'.json');
$page = str_replace('\/','/', $page );
file_put_contents('/var/www/html/saas/jsonclients/'.$_POST['saasname'].'.json',$page);

echo json_encode($my) ;
