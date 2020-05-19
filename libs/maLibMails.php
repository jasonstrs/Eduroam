<?php
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
                   
                }
            </style>
        </head>
        <body>
        <div>
            <p>Bonjour $prenom $nom !</p>
            <b>Avant de commencer...</b>
            <p>Veuillez valider votre adresse mail afin de pouvoir vous connecter</p>
            <a href='". $lien ."'>
                <button style=' border:3px rgb(255,0,50) outline;
                background-color:red;
                color:white;
                text-align:center;
                max-width:30%;'>
                    Confirmer
                </button>
            </a>
        </div>
        </body>
    </html>
    ";

    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    // En-têtes additionnels
    $headers[] = 'From:Site Web JSPC <noreply.jspc@example.com>';

    return envoyerMail($to,$sujet,$message,$headers);
}

function mailChangerPass($to,$nom,$prenom,$lien){
    $sujet = "Changement de mot de passe";
    $message="
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset=\"UTF-8\">
        </head>
        <body>
        <div>
            <p>Bonjour $prenom $nom !</p>
            <b>Une demande de réinitialisation de mot de passe a été demandée sur votre compte.</b>
            <p>Si vous êtes bien à l'origine de cette demande, cliquez sur le lien ci-dessous</p>
                <a href='$lien'>Veuillez cliquer ici pour changer votre mot de passe.</a>
        </div>
        </body>
    </html>
    ";

    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    // En-têtes additionnels
    $headers[] = 'From: Site Web JSPC <noreply.jspc@example.com>';

    return envoyerMail($to,$sujet,$message,$headers);
}


function mailSpectacleValide($to){
    $now = date("Y-m-d");
    setLastMail($to,$now);
    $sujet = "Une date qui vous intéresse vient d'être validée";
    $message="
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset=\"UTF-8\">
        </head>
        <body>
        <div>
            <p>Bonjour $to !</p>
            <b>Une date qui vous intéressait vient d'être confirmée ! </b>
            <p>Connectez-vous sur le site, et accédez à la section <b>Spectacles > Vos Dates Validées</b></p> 
            <p>Cliquez sur la date voulue pour accéder au site de vente de billets. Si le lien n'est pas disponible, contactez u nadministrateur.</p> 
        </div>
        </body>
    </html>
    ";

    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    // En-têtes additionnels
    $headers[] = 'From: Site Web JSPC <noreply.jspc@example.com>';

    return envoyerMail($to,$sujet,$message,$headers);
}