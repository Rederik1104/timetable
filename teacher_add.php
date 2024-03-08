<?php
$first_name = htmlentities($_POST["first_name"]);
$last_name = htmlentities($_POST["last_name"]);
$subject1 = htmlentities($_POST["subject_1"]);
$subject2 = htmlentities($_POST["subject_2"]);
session_start();
$userID = $_SESSION["userID"];

echo $first_name, $last_name, $subject1, $subject2, $userID

?>