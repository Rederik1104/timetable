<?php
session_start();
$oPass = $_POST['oPass'];
$nPass = $_POST['nPass'];
$userID = $_SESSION['userID'];

include("database.php");
$sql = $pdo->query("SELECT password FROM users WHERE id = :id");
$sql->bindParam(":id", $userID);
while($row = $sql->fetch()){
    if(password_verify($oPass, $row['password'])){
        $stmt = $pdo->query("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(":password", $password);
    }else{
        echo "password is false!";
        header("Location: user.php");
        exit();
    }
}