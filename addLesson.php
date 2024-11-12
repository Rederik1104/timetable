<?php
session_start();
include("database.php");

$isAlone = true;

$day = $_GET["day"];
$lesson = $_GET["lesson"];
$subject = $_GET["subject_name"];
$userID = $_SESSION["userID"];
$subjectID = 0;

$lessonSplit = explode('_', $lesson);

if($lessonSplit[0] == "break"){
    header("Location: stundenplan.php");
    exit();
}

$sqlDetect = $pdo->query("SELECT * FROM schedules");
while($row = $sqlDetect->fetch()){
     if($row['day'] == $day && $row['lesson'] == $lesson){
        $isAlone = false;
        $equalDay = $row['day'];
        $equalLesson = $row['lesson'];
     }
}

if($isAlone){
    $sql = "SELECT * FROM subject";
    $stmt = $pdo->query($sql);
    While($row = $stmt->fetch()){
        if($row['subject_name'] == $subject){
            $subjectID = $row['ID'];
        }
    }



    $sql = $pdo->prepare("INSERT INTO schedules (userID, subjectID, teacherID, roomID, day, lesson, duration) VALUES (:userID, :subjectID, '1', '1', :day, :lesson, '1')");
    $sql->bindParam( ":userID", $userID);
    $sql->bindParam(":subjectID", $subjectID);
    $sql->bindParam(":day", $day);
    $sql->bindParam(":lesson", $lesson);

    if($sql->execute()){
        header("Location: stundenplan.php");
        json_decode('{"isAlone:"true, "excecuted:"true}');
        exit();
    }else{
        header("Location: stundenplan.php");
        json_decode('{"isAlone:"true, "excecuted:"false}');
        exit();
    }
}else{

    $delete = $pdo->prepare("DELETE FROM schedules WHERE day = :day AND lesson = :lesson");
    $delete->bindParam(":day", $day);
    $delete->bindParam(":lesson", $lesson);
    $delete->execute();

    $sql = "SELECT * FROM subject";
    $stmt = $pdo->query($sql);
    While($row = $stmt->fetch()){
        if($row['subject_name'] == $subject){
            $subjectID = $row['ID'];
        }
    }



    $sql = $pdo->prepare("INSERT INTO schedules (userID, subjectID, teacherID, roomID, day, lesson, duration) VALUES (:userID, :subjectID, '1', '1', :day, :lesson, '1')");
    $sql->bindParam( ":userID", $userID);
    $sql->bindParam(":subjectID", $subjectID);
    $sql->bindParam(":day", $day);
    $sql->bindParam(":lesson", $lesson);

    if($sql->execute()){
        header("Location: stundenplan.php");
        json_decode('{"isAlone:"false, "excecuted:"true}');
        exit();
    }else{
        header("Location: stundenplan.php");
        json_decode('{"isAlone:"false, "excecuted:"false}');
        exit();
    }
    
}

