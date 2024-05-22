<?php

$teacherID = $_GET["teacherID"];

include("database.php");
$stmt = "DELETE FROM teacher WHERE id = $teacherID";
if($pdo->query($stmt)){
    header("Location: infos.php");
    exit();
}
?>