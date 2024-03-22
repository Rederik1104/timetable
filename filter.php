<?php

$value = $_GET["js_value"];
echo $value;

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
    $sql = "UPDATE filter SET ln = true, fn = false, s1 = false, s2 = false";
}
else if($value == "2"){
    $sql = "UPDATE filter SET ln = false, fn = true, s1 = false, s2 = false";
}
else if($value == "3"){
    $sql = "UPDATE filter SET ln = false, fn = false, s1 = true, s2 = false";
}
else{
    $sql = "UPDATE filter SET ln = false, fn = false, s1 = false, s2 = true";
}

if($pdo->query($sql)){
    header("Location: infos.php");
}



?>