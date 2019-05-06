<?php
/* CREATE A CONNECTION TO THE SERVER */
    $dsn = 'mysql:host=jcaruso.site;dbname=jaredca3_groupa19_ezcheezy';
    $username = 'jaredca3_user';
    $password = 'password';
try{
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo 'ERROR connecting to database!' . $e->getMessage();
    exit();
}
?>
