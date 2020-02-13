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
        $mail->Body    = "<h4>Merci de votre inscription</h4><br><p>Vous venez de vous inscrire sur le site ...... Afin de pouvoir vous connecter, vous devez confirmer votre
        adresse mail.<br><a href=\"localhost/Eduroam/minControleur/verificationMail".$lien."\"  style=\"cursor:pointer;\"> Pour cela, Veuillez cliquer ici ! </a></p>";
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}