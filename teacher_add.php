<?php
$first_name = htmlentities($_POST["first_name"]);
$last_name = htmlentities($_POST["last_name"]);
$subject1 = htmlentities($_POST["s1"]);
$subject2 = htmlentities($_POST["s2"]);
session_start();
$userID = $_SESSION["userID"];


echo $first_name, $last_name, $subject1, $subject2, $userID;

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

$stmt = "INSERT INTO teacher (name, vorname, subjectID1, subjectID2, createdBY) VALUES ($last_name, $first_name, $subject1, $subject2, $userID)";
if($stmt == TRUE){
    //header("location: infos.php");
}

?>