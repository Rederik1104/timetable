<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Create a new Dotenv instance
$dotenv = Dotenv::createUnsafeImmutable(__DIR__);

// Load the environment variables
$dotenv->load();
$dsn = "mysql:dbname=erik;host=Content.goatserver.de";
$username = "erik";
$password = getenv('DB_PASSWORD');    
$con = new PDO($dsn, $username, $password);
if (isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $stmt = $con->prepare("SELECT * FROM users WHERE username=:username");
    $stmt->bindParam("username", $username);
    $stmt->execute();
    $userExists = $stmt->fetchAll();
    var_dump($userExists);
    $passwordHashed = $userExists[0]["password"];
    $checkPassword = password_verify($password, $passwordHashed);
    if($checkPassword == false){
        header("Location: login_failure.php");
    }
    if($checkPassword == true){
        session_start();
        $_SESSION["username"] = $userExists[0]["username"];

        header("Location: infos.php");
    }
}


?>


<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <form action="login.php" method="POST">
        <h1>Login</h1>
        <div class="inputs_container">
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="password" placeholder="Login fehlgeschlagen" name="password" autocomplete="off">
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