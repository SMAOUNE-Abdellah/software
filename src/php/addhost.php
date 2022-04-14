<?php
include "db.php";
include "cors-header.php";
$distribution =$_POST['hostos'];
$hostuser =$_POST['hostuser'];
$hostip =$_POST['hostip'];
$hostps = $_POST['hostps'];

if (isset($distribution,$hostuser,$hostip,$hostps)) {
    # code...
   // if (filter_var($hostip,FILTER_VALIDATE_IP)) {
        # code...
        $data = [];
        $querys = "SELECT * FROM worker WHERE ip = '$hostip'";
        $sqls = $connexion->query($querys);
        while ($rows = mysqli_fetch_assoc($sqls)) {
            $data[] = $rows;
        }
        if (empty($data)) {
            # code...
            $query = "INSERT INTO worker (`name`, `ip`, `user`, `ps`) VALUES ('$distribution','$hostip','$hostuser','$hostps')";
            $connexion->query($query);
        }
    //}
       $hostip = escapeshellarg($hostip);
       $hostps = escapeshellarg($hostps);
       $hostuser = escapeshellarg($hostuser);
       $addinfo=shell_exec('sudo /var/www/html/scriptbash/Addworker.sh ' .$hostip.' '.$hostps); 
        if ($distribution=="Centos"){
           $command="sudo ansible-playbook /etc/ansible/configurationCentos.yml --vault-password-file=/etc/ansible/.vault_pass -e 'IPaddresse=$hostip username=$hostuser' --connection-password-file /var/www/html/scriptbash/connection.txt";
        }else{
           $command="sudo ansible-playbook /etc/ansible/configurationUbuntu.yml --vault-password-file=/etc/ansible/.vault_pass -e 'IPaddresse=$hostip username=$hostuser' --connection-password-file /var/www/html/scriptbash/connection.txt";
        }
       $hostconfig=shell_exec($command);
       echo "<pre>";
       echo $hostconfig;
       echo "</pre><br/>";

}



