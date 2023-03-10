<?php

require_once('databases.inc.php');

$db = $databases['dev'];

try
{
    $bdd = new PDO($db['dsn'], $db['username'], $db['password'], [
        PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION
    ]);
}
catch(PDOException $e)
{
    print "Erreur :".$e->getMessage()."<br/>";
    die();
}