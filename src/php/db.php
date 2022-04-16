<?php

$connexion = new mysqli("localhost","root","11111998","saas");
if (!$connexion) {
    
    echo "error, database not found";
}
