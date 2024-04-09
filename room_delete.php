<?php

    $roomID = $_GET["roomID"];
    $dbconfig['host'] = 'localhost';
    $dbconfig['user'] = 'root';
    $dbconfig['base'] = 'login';
    $dbconfig['pass'] = '';
    $dbconfig['char'] = 'utf8';

    try {
        $pdo = new
        PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
        $dbconfig['user'], $dbconfig['pass']);
    }
    catch(PDOException $e) {
        exit('Unable to connect Database.');
    }
    $delete = $pdo->query("DELETE FROM room WHERE roomID = $roomID");

    if($delete){
        header("Location: infos.php");
    }


?>