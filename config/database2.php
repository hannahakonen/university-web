<?php
$DB_HOST = '';
$DB_NAME = '';
$DB_USER = '';
$DB_PASSWORD = '';

$LOCAL = in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','REMOTE_ADDR' => '::1'));
if ($LOCAL) {	
    $tunnukset = "../../../../../salasanapiilo/tunnukset-db.php";
    if (file_exists($tunnukset)){
        include_once("../../../../../salasanapiilo/tunnukset-db.php");
        } 
    else {
        die("Tiedostoa ei löydy, ota yhteys ylläpitoon.");
    };

    $DB_HOST = '$db_server_local';
    $DB_NAME = 'auth';
    $DB_USER = '$db_username_local';
    $DB_PASSWORD = '$db_password_local';

} elseif (strpos($_SERVER['HTTP_HOST'],"azurewebsites") !== false){
    $db_server = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
    $db_username = $_ENV['DB_USER'] ?? getenv('DB_USER');
    $db_password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');

}
