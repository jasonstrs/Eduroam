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
                <a style='' href='". $lien ."'><i>Pour la confirmer, veuillez cliquer <i> ici ! </a>
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
                <a style='' href='". $lien ."'><i>Pour le modifier, veuillez cliquer <i>ici !</a>
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

/**
 * Vérifie les infos entrées avant d'envoyer le mail
 */
function envoyerMail($to,$sujet,$message,$tabHeaders){
    return mail($to,$sujet,$message,implode("\r\n",$tabHeaders));
}

/**
 * Mail contenant un lien permettant de finaliser l'inscription d'un membre.
 */
function mailInscription($to,$nom,$prenom,$lien){
    $sujet = "Finalisation de l'inscription ! ";
    $message="
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset=\"UTF-8\">
            <style>
                button{
                    border:3px rgb(255,0,50) outline;
                    background-color:red;
                    color:white;
                    text-align:center;
                    max-width:30%;
                }
            </style>
        </head>
        <body>
        <div>
            <p>Bonjour $prenom $nom !</p>
            <b>Avant de commencer...</b>
            <p>Veuillez valider votre adresse mail afin de pouvoir vous connecter</p>
            <a href='". $lien ."'>
                <button>
                    Veuillez cliquer ici pour confirmer votre adresse e-mail.
                </button>
            </a>
        </div>
        </body>
    </html>
    ";

    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    // En-têtes additionnels
    $headers[] = 'From: JSPC <noreply.jspc@example.com>';

    return envoyerMail($to,$sujet,$message,$headers);
}


/*   
    // Plusieurs destinataires
     $to  = 'johny@example.com, sally@example.com'; // notez la virgule

     // Sujet
     $subject = 'Calendrier des anniversaires pour Août';

     // message
     $message = '
     <html>
      <head>
       <title>Calendrier des anniversaires pour Août</title>
      </head>
      <body>
       <p>Voici les anniversaires à venir au mois d\'Août !</p>
       <table>
        <tr>
         <th>Personne</th><th>Jour</th><th>Mois</th><th>Année</th>
        </tr>
        <tr>
         <td>Josiane</td><td>3</td><td>Août</td><td>1970</td>
        </tr>
        <tr>
         <td>Emma</td><td>26</td><td>Août</td><td>1973</td>
        </tr>
       </table>
      </body>
     </html>
     ';

     // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers[] = 'MIME-Version: 1.0';
     $headers[] = 'Content-type: text/html; charset=iso-8859-1';

     // En-têtes additionnels
     $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
     $headers[] = 'From: Anniversaire <anniversaire@example.com>';
     $headers[] = 'Cc: anniversaire_archive@example.com';
     $headers[] = 'Bcc: anniversaire_verif@example.com';

     // Envoi
     mail($to, $subject, $message, implode("\r\n", $headers)); 
     
*/