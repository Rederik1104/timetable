<?php

$value = $_GET["js_value"];

include "database.php";

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