<?php
$dsn = "mysql:dbname=login;host=localhost";
$username = "root";
$password = "";
$con = new PDO($dsn, $username, $password);

if (isset($_POST["submit"])){
    $username = strtolower($_POST["username"]);
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
        $stmt = $con->query("SELECT * FROM users");
        while($row = $stmt->fetch()){
            $ID = $row["id"];
            $un = $row["username"];
            $pw = $row["password"];
            if($un == $username && password_verify($password, $pw)){
                $userID = $ID;
            }
        }
        session_start();
        $_SESSION["userID"] = $userID;
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
    </form>
    
</body>
</html>