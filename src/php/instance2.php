<?php
include "db.php";
include "cors-header.php";
$service_name = $_POST['service_name'];
$client_selected_name = $_POST['saasname'];

//API Call
$domain = "dzshops.net";
$API_KEY = "fYqYjZBDqjX1_XsfPqBP1FnYChyHWHMsayt";
$API_SECRET = "GWnjGKB8A8qg7Z7vNXccad";
$dns_domain = strtolower($domain);
$dns_type = 'A';
$dns_name = $_POST['saasname']; // must be the name of the client,this is the prefix of the subdomain
$dns_data = str_replace(" ", "" , $_POST['ip_add']);  //must be the ip address of the worker
$dns_port = 80;
$dns_priority = 10;
$dns_protocol = 'string';
$dns_service = 'string';
$dns_ttl = 600;
$dns_weight = 10;

$dns_record = "[{\"data\": \"$dns_data\",\"port\": $dns_port,\"priority\": $dns_priority,\"protocol\": \"$dns_protocol\",\"service\": \"$dns_service\",\"ttl\": $dns_ttl,\"weight\": $dns_weight}]";
$response = addDNSRecord($dns_domain,$dns_type,$dns_name,$dns_record); 
//Function to add a subdomain
function addDNSRecord($DNS_domain,$DNS_type,$DNS_name,$DNS_record){
      global $API_KEY, $API_SECRET;

      $url = "https://api.godaddy.com/v1/domains/$DNS_domain/records/$DNS_type/$DNS_name";
      $header = array(
              "Authorization: sso-key $API_KEY:$API_SECRET",
              'Content-type: application/json',
              'Accept: application/json'
      );

      $connexion = curl_init();
      $timeout = 60;

      curl_setopt($connexion, CURLOPT_URL, $url);
      curl_setopt($connexion, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($connexion, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($connexion, CURLOPT_CONNECTTIMEOUT, $timeout);
      curl_setopt($connexion, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($connexion, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($connexion, CURLOPT_POSTFIELDS, $DNS_record);
      curl_setopt($connexion, CURLOPT_HTTPHEADER, $header);

      $result = curl_exec($connexion);
      curl_close($connexion);

      $response = json_decode($result, true);
      return $response;
}
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
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][]['VIRTUAL_HOST'] =  $client_selected_name.".".$dns_domain;
        $saas['services'][$k][substr($_POST['saasname']."_".$img[$k]['name'],0,-4)]['environment'][]['LETSENCRYPT_HOST'] = $client_selected_name.".".$dns_domain;
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
            $request = file_get_contents('/var/www/html/saasautomation/src/php/SQL-Request/'.$var[$k][$l]['key'].'.sql');
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

$client_id = [];
$query1 = "SELECT * FROM clients WHERE fname = '$client_selected_name'";
$sql1 = $connexion->query($query1);
while ($row1 = mysqli_fetch_assoc($sql1)) {
    
    $client_id[] = $row1;
    
}
$service_id = [];
$query2 = "SELECT * FROM services WHERE name = '$service_name'";
$sql2 = $connexion->query($query2);
while ($row2 = mysqli_fetch_assoc($sql2)) {
    
    $service_id[] = $row2;
    
}
$id0 = $client_id[0]['id_clients'];
$id1 = $service_id[0]['id_services'];
$query = "INSERT INTO services_clients (`services_id`,`clients_id`,`comp`) VALUES('$id1','$id0','$my')";
$connexion->query($query);
// Create the json file for the client that contain information about backup.
$info = array();
for ($s=0; $s < count($img); $s++) { 
    # code...
    $info[$s]['container_name'] = $_POST['saasname']."_".substr($img[$s]['name'],0,-4);
    $info[$s]['backup_path'] = $img[$s]['backup'];
}
$json_info = json_encode($info);
file_put_contents('/var/www/html/saasautomation/jsonclients/'.$_POST['saasname'].'.json',$json_info);
$page = file_get_contents('/var/www/html/saasautomation/jsonclients/'.$_POST['saasname'].'.json');
$page = str_replace('\/','/', $page );
file_put_contents('/var/www/html/saasautomation/jsonclients/'.$_POST['saasname'].'.json',$page);

echo json_encode($my) ;



 
