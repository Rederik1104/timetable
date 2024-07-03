<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $dsn = "mysql:dbname=erik;host=Content.goatserver.de";
    $username = "erik";
    $password = getenv('DB_PASSWORD');
    $con = new PDO($dsn, $username, $password);

    if(isset($_POST["submit"])){
        $usern = $_POST["username"];
        $usern = strval($usern);
        $email = $_POST["email"];
        $password = PASSWORD_HASH($_POST["password"], PASSWORD_DEFAULT);

        $sql = $con->prepare("SELECT id FROM users WHERE username=:username;");
        $sql->bindParam(":username", $usern);
        $sql->execute();
        $userAlreadyExists = $sql->fetch();
        if(!$userAlreadyExists){
            //register user
            registerUser(strtolower($usern), $email, $password);
        }
        else{
            //user is already registered
            header("Location: register_failure.php");
            exit();
        }
    
    }

    function registerUser($usern, $email, $password){
        global $con;

        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function
            
        //Load Composer's autoloader
        require 'vendor/autoload.php';
            
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
            
        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.gmx.net';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'rederik1104@gmx.de';                     //SMTP username
            $mail->Password   = getenv("GMX_PASSWORD");                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 465
            
            //Recipients
            $mail->setFrom('rederik1104@gmx.de', 'Erik');
            $mail->addAddress($email, 'Erik');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
            //Content
            $code = rand(100000, 999999);
            $_SESSION["V-code"] = $code;
            
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verification, Timy';
            $mail->Body    = "Here is your verification code: $code";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            $mail->send();
            //echo 'Message has been sent';
            //$_SESSION["V-code"] = $code;
            $locked_code = password_hash($code, PASSWORD_DEFAULT);

            header("Location: register_verification.php?email=$email&user=$usern&password=$password"); 
            exit();
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            sleep(5);
            header("Location: user.php");
            exit();
        } 
    }

    if(isset($_SESSION['userData'])){
        include("database.php");
        $nEmail = $_SESSION['userData']['email'];
        $name = $_SESSION['userData']['given_name'];
        $pass = $_SESSION['userData']['kid'];
        $stmt = $pdo->query("SELECT * FROM users");
        while($row = $stmt->fetch()){
            if($row['username'] == $name && $row['email'] == $nEmail && $row['password'] == $pass){
                $_SESSION["userID"] = $row['id'];
                header("Location: infos.php");
                exit();
            }
        }
        $sql = $pdo->prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
        $sql->bindParam(":username", $name);
        $sql->bindParam(":email", $nEmail);
        $sql->bindParam("password", $pass);
        if($sql->execute()){
            $stmt = $pdo->query("SELECT * FROM users");
            while($row = $stmt->fetch()){
                if($name == $row['username'] && $pass == $row['password']){
                    $userID = $row['id'];
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
    <title>Registrieren</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <form action="index.php" method="POST">
        <h1>Create Account</h1>
        <div class="inputs_container">
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="text" placeholder="Email" name="email" autocomplete="off">
            <input type="password" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button name="submit">Create</button>
        <a href="login.php" style="
            color:white;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 19px;
            background-image: linear-gradient(to right, rgb(162,0,255), rgb(74,15,236));
            background-size: 100% 4px;
            background-position: bottom;
            background-repeat: no-repeat;
            line-height: 30px;
            text-decoration: none;
        ">Login</a>
        <a href="google/redirect.php"  style="
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
        ">Login with Google</a> 
    </form>
    
</body>
</html>