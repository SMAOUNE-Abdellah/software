<?php

$connexion = new mysqli("localhost","root","11111998","vue-php");
if (!$connexion) {
    
    echo "error, database not found";
}
