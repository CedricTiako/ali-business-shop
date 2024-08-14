<?php
require 'ConnectMySQL.php'; // Assurez-vous que ce chemin est correct

$host = 'localhost'; // Changez selon votre configuration
$dbname = 'your_database_name'; // Changez selon votre configuration
$username = 'your_username'; // Changez selon votre configuration
$password = 'your_password'; // Changez selon votre configuration

function getDB() {
    global $host, $dbname, $username, $password;
    return new ConnectMySQLDB($host, $dbname, $username, $password);
}
?>
