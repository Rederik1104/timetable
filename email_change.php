<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    
    if($_POST["email1"] == $_POST["email2"]){

        session_start();
        $userID = $_SESSION["userID"];
        $newEmail = $_POST["email1"];

        $dbconfig['host'] = 'localhost';
        $dbconfig['user'] = 'root';
        $dbconfig['base'] = 'login';
        $dbconfig['pass'] = '';
        $dbconfig['char'] = 'utf8';
                                    
        try {
            $pdo = new
            PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
            $dbconfig['user'], $dbconfig['pass']);
        }
        catch(PDOException $e) {
            exit('Unable to connect Database.');
        }

        $emailChange = "UPDATE users SET email = :newEmail WHERE id = :id";
        $stmt = $pdo->prepare($emailChange);
        $stmt->bindParam(":newEmail", $newEmail);
        $stmt->bindParam(":id", $userID);
        if($stmt->execute()){
            //Import PHPMailer classes into the global namespace
            //These must be at the top of your script, not inside a function
            
            //Load Composer's autoloader
            require 'vendor/autoload.php';
            
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'ersenkbeil@gmail.com';                     //SMTP username
                $mail->Password   = 'Zupomiwo.8';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('ersenkbeil@gmail.com', 'Erik');
                $mail->addAddress('ersenkbeil@gmail.com', 'Erik');     //Add a recipient
                //$mail->addAddress('ellen@example.com');               //Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
            
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
                //Content
                $code = rand(1000, 9999);
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Verification';
                $mail->Body    = "Here is your verification code: $code";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            } 


            //header("Location: user.php"); 
        }
    }
    else
    {
        
        header("Location: user.php");
    }
    
?>