<?php
$first_name = htmlentities($_POST["first_name"]);
$last_name = htmlentities($_POST["last_name"]);
$subject1 = htmlentities($_POST["s1"]);
$subject2 = htmlentities($_POST["s2"]);
$discription = htmlentities($_POST["discription"]);
session_start();
$userID = $_SESSION["userID"];

$subject1 = (int)$subject1;
$subject2 = (int)$subject2;
$userID = (int)$userID;

echo $first_name, $last_name, $subject1, $subject2, $userID;

include "database.php";

$sql = "INSERT INTO teacher (name, vorname, subjectID1, subjectID2, createdBY, discription) VALUES (:last_name, :first_name, :subject1, :subject2, :userID, :discription)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':last_name', $last_name);
$stmt->bindParam(':first_name', $first_name);
$stmt->bindParam(':subject1', $subject1);
$stmt->bindParam(':subject2', $subject2);
$stmt->bindParam(':userID', $userID);
$stmt->bindParam(':discription', $discription);

if($stmt->execute()){
    header("location: infos.php");
}

?>