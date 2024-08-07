<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Create a new Dotenv instance
$dotenv = Dotenv::createUnsafeImmutable(__DIR__);

// Load the environment variables
$dotenv->load();

session_start();
$dsn = "mysql:dbname=erik;host=Content.goatserver.de";
$username = "erik";
$password = getenv('DB_PASSWORD');
$con = new PDO($dsn, $username, $password);

if (isset($_POST["submit"])){
    $username = strtolower($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $con->prepare("SELECT * FROM users WHERE username=:username");
    $stmt->bindParam("username", $username);
    $stmt->execute();
    $userExists = $stmt->fetchAll();

    if(count($userExists) == 0){
        header("Location: login_failure.php");
        exit();
    }

    $passwordHashed = $userExists[0]["password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if($checkPassword == false){
        header("Location: login_failure.php");
        exit();
    }
    if($checkPassword == true){
        
        $_SESSION["username"] = $userExists[0]["username"];
        $stmt = $con->query("SELECT * FROM users");
        while($row = $stmt->fetch()){
            $ID = $row["id"];
            $un = $row["username"];
            $pw = $row["password"];
            if($un == $username && password_verify($password, $pw)){
                $userID = $ID;
                break;
            }
        }
        $_SESSION["userID"] = $userID;
        header("Location: infos.php");
        exit();
    }
}


?>


<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form action="login.php" method="POST">
        <h1>Login</h1>
        <div class="inputs_container">
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="password" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button name="submit">Login</button>
        <a href="index.php" style="
            color:white;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 19px;
            background-image: linear-gradient(to right, rgb(162,0,255), rgb(74,15,236));
            background-size: 100% 4px;
            background-position: bottom;
            background-repeat: no-repeat;
            line-height: 30px;
            text-decoration: none;
            text-align:center;
            align-items:center;
        ">back to registration</a>
    </form>
    
</body>
</html>