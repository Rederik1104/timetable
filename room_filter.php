<?php

$value = $_GET["value"];

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

if($value == "1"){
    $sql = "UPDATE filterroom SET building = true, number = false, description = false";
}
else if($value == "2"){
    $sql = "UPDATE filterroom SET building = false, number = true, description = false";
}
else{
    $sql = "UPDATE filterroom SET building = false, number = false, description = true";
}

if($pdo->query($sql)){
    header("Location: infos.php");
}

?>