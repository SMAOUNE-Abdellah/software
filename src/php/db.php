<?php

$connexion = new mysqli("localhost","root","","vue-php");
if (!$connexion) {
    
    echo "error, database not found";
}