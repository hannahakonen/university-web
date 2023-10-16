<?php
include_once("../../../../../salasanapiilo/tunnukset-db.php");


//Local toimii
$LOCAL = in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','REMOTE_ADDR' => '::1'));
if ($LOCAL) {	
    $tunnukset = "../../../../../salasanapiilo/tunnukset-db.php";
    if (file_exists($tunnukset)){
        include_once("../../../../../salasanapiilo/tunnukset-db.php");
        } 
    else {
        die("Tiedostoa ei löydy, ota yhteys ylläpitoon.");
    };
    define('DB_HOST', $db_server_local);
    define('DB_NAME', 'auth');
    define('DB_USER', $db_username_local);
    define('DB_PASSWORD', $db_password_local);

//Azure
} elseif (strpos($_SERVER['HTTP_HOST'],"azurewebsites") !== false){
    $db_server = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
    $db_username = $_ENV['DB_USER'] ?? getenv('DB_USER');
    $db_password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');

}

/* Mailtrap */
define("EMAIL_HOST",'smtp.mailtrap.io');
define("EMAIL_PORT",2525);
define("EMAIL_USERNAME",$username_mailtrap);
define("EMAIL_PASSWORD",$password_mailtrap);