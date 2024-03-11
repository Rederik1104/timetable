<?php

$teacherID = $_GET["teacherID"];
echo $teacherID;

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
$stmt = "DELETE FROM teacher WHERE id = $teacherID";
if($pdo->query($stmt)){
    header("Location: infos.php");
}
?>