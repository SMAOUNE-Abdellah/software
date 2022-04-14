<?php
include "db.php";
include "cors-header.php";
$nginx_connexion = $_POST['nginx'];
if ($_POST['nginx'] != 'network') {
    # code...
    $container_related_name = $_POST['client'].'_'.substr($_POST['nginx'],0,-4);

}
else $container_related_name = null;
$client_network = $_POST['client'].'_networks';
file_put_contents('/var/www/html/saas/src/php/docker-compose.yaml', $_POST['yaml']); 
$page = file_get_contents('/var/www/html/saas/src/php/docker-compose.yaml');
$page = str_replace('-',' ', $page );
$page = str_replace('tiret','- ',$page);
$page = str_replace('space','-',$page);
$page = str_replace('"{{}}"','',$page);
$result=file_put_contents('/var/www/html/saas/src/php/docker-compose.yaml',$page);

echo $container_related_name;
//Add system script to deploy the service for the client
$serverdeploy = $_POST['ip'];
$serverdeploy = escapeshellarg($serverdeploy);
$clientname = $_POST['client'];
$clientname = escapeshellarg($clientname);
$client_network = escapeshellarg($client_network);
$container_related_name = escapeshellarg($container_related_name);

$command = "sudo ansible-playbook /etc/ansible/deployservice.yml --vault-password-file=/etc/ansible/.vault_pass -e 'IPaddresse=$serverdeploy client_name=$clientname' ";
$deployservice = shell_exec($command);
echo "<pre>";
echo $deployservice;
echo "</pre><br/>";

if ($_POST['nginx'] != 'network'){
    $comd = "sudo ansible-playbook /etc/ansible/NginxtoContainer.yml --vault-password-file=/etc/ansible/.vault_pass -e 'IPaddresse=$serverdeploy container_name=$container_related_name' ";
    $nginx = shell_exec($comd);

}else{
    $comd = "sudo ansible-playbook /etc/ansible/NginxToNetwork.yml --vault-password-file=/etc/ansible/.vault_pass -e 'IPaddresse=$serverdeploy client_network_name=$client_network '";
    $nginx = shell_exec($comd);
}

echo "<pre>";
echo $nginx;
echo "</pre>";

// Add the backup script

$backup_type = $_POST['backup_type'];
$backup_number = $_POST['backup_number']; 
$ip = $_POST['ip'];
$client_name = $_POST['client'];
  
if ($backup_type == "SCP"){

    if($backup_number =="one a day"){
      shell_exec("(crontab -l ; echo \"00 23 * * * sudo ansible-playbook /etc/ansible/backup.yml --vault-password-file=/etc/ansible/.vault_pass -e'IPaddresse=$ip client_name=$client_name'\") | sort | uniq | crontab");
    }elseif($backup_number == "one a week"){
      shell_exec("(crontab -l ; echo \"00 23 * * 6 sudo ansible-playbook /etc/ansible/backup.yml --vault-password-file=/etc/ansible/.vault_pass -e'IPaddresse=$ip client_name=$client_name'\") | sort | uniq | crontab");
    }else{
      shell_exec("(crontab -l ; echo \"00 23 28 * * sudo ansible-playbook /etc/ansible/backup.yml --vault-password-file=/etc/ansible/.vault_pass -e'IPaddresse=$ip client_name=$client_name'\") | sort | uniq | crontab");
    }

}














