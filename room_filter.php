<?php

$value = $_GET["value"];

include "database.php";

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