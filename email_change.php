<?php
    require __DIR__ . '/vendor/autoload.php';
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    use Dotenv\Dotenv;
    

    
    // Create a new Dotenv instance
    $dotenv = Dotenv::createUnsafeImmutable(__DIR__);
    
    // Load the environment variables
    $dotenv->load();
    $userID = $_SESSION["userID"];
    $newEmail = $_POST["email1"];
    
    
    if($_POST["email1"] == $_POST["email2"]){
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
                $mail->addAddress($newEmail, 'Erik');     //Add a recipient
                //$mail->addAddress('ellen@example.com');               //Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
            
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
                //Content
                $code = rand(100000, 999999);
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Verification, Timy';
                $mail->Body    = "Here is your verification code: $code";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                //echo 'Message has been sent';
                $_SESSION["Vcode"] = $code;
                header("Location: verification.php?email=$newEmail"); 
                exit();
            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                sleep(5);
                header("Location: user.php");
                exit();
            } 


        }

    else
    {
        
        header("Location: user.php");
    }
    
?>