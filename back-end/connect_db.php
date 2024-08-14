<?php
require 'ConnectMySQLDB.php'; // Assurez-vous que ce chemin est correct

$host = 'localhost'; // Changez selon votre configuration
$dbname = 'boutique_en_ligne'; // Changez selon votre configuration
$username = 'root'; // Changez selon votre configuration
$password = ''; // Changez selon votre configuration

function getDB() {
    $host = 'localhost'; // Changez selon votre configuration
    $dbname = 'boutique_en_ligne'; // Changez selon votre configuration
    $username = 'root'; // Changez selon votre configuration
    $password = ''; // Changez selon votre configuration
    return new ConnectMySQLDB($host, $dbname, $username, $password);
}
?>
