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
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('erreur@example.com', 'J\'suis pas content TV');
        $mail->addAddress($email, $nom . " " . $prenom);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "

        <!doctype html>
        <html lang='fr'>
        <head>
            <meta charset='utf-8'>
        </head>
        <body style='text-align:center;'>
        
        <div>
            <h3 style='margin-bottom=0px;'><b>Avant de <span style='color:red;'>commencer...</span></b></h3>
            <p>Veuillez vérifier votre adresse mail afin de pouvoir vous connecter</p>
            <button style='
                color: #fff;
                background-color: #dc3545;
                border-color: #dc3545;        
            ' style='cursor:pointer'>Confirmer votre adresse mail</button>
            
        </div>
        </body>
        </html>
        
        ";
        
        //        <img src='http://localhost/Eduroam/ressources/logo.png'>

        /*<style>

        img {
            max-width: 70px;
            max-height: 70px;
        }
    
        </style>
        
        <h4>Merci de votre inscription</h4><p>Vous venez de vous inscrire sur le site ...... Afin de pouvoir vous connecter, vous devez confirmer votre
        adresse mail.<a href=\"localhost/Eduroam/minControleur/verificationMail".$lien."\"  style=\"cursor:pointer;\"> Pour cela, Veuillez cliquer ici ! </a></p>*/

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
        $mail->Body    = "<h4>Mot de passe oublié</h4><p>Vous venez de demander un nouveau mot de passe. <a href=\"localhost/Eduroam/minControleur/verificationMail".$lien."\"  style=\"cursor:pointer;\"> Pour le modifier, Veuillez cliquer ici ! </a></p>";
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}