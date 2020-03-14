<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function envoiMail($email,$subject,$nom,$prenom,$lien){
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'testpinf@gmail.com';                     // SMTP username
        $mail->Password   = 'Azerty59';                               // SMTP password
        $mail->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;  
        $mail->CharSet = 'UTF-8';                                  // TCP port to connect to

        //Recipients
        $mail->setFrom('erreur@example.com', 'J\'suis pas content TV');
        $mail->addAddress($email, $nom . " " . $prenom);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        //$mail->Body = file_get_contents('mail.html');
        $mail->Body="
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset=\"UTF-8\">
            </head>
            <body>
            <div>
                <h3 style='margin-bottom:0px;'><b>Avant de <span style='color:red;'>commencer...</span></b></h3>
                <p>Veuillez valider votre adresse mail afin de pouvoir vous connecter</p>
                <a style='cursor:pointer; text-decoration:none; color:red;' href='". $lien ."'><i>Pour confirmer celle-ci, veuillez cliquer ici !<i></a>
            </div>
            </body>
        </html>
        ";
        
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function envoiMailPass($email,$subject,$nom,$prenom,$lien){
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'testpinf@gmail.com';                     // SMTP username
        $mail->Password   = 'Azerty59';                               // SMTP password
        $mail->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('erreur@example.com', 'J\'suis pas content TV');
        $mail->addAddress($email, $nom . " " . $prenom);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "
        
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset=\"UTF-8\">
            </head>
            <body>
            <div>
                <h3 style='margin-bottom:0px;'><b>Mot de passe oublié</b></h3>
                <p>Vous venez de demander un nouveau mot de passe.</p>
                <a style='cursor:pointer; text-decoration:none; color:red;' href='". $lien ."'><i>Pour le modifier, veuillez cliquer ici !<i></a>
            </div>
            </body>
        </html>
        
        
        ";
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}