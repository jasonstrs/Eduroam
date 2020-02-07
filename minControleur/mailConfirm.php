<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";
   include_once "../libs/maLibPHPMailer.php";
   
    if (valider("email")){ // on vérifie que toutes les valeurs sont définies
        $email = valider('email');
        if (verifExistMail($email)){ // l'adresse est existante
            if(isConfirmViaMail($email)){ // on regarde si le mail est déjà confirmé
                echo "confirm";
            } else {
                // ici on envoie un mail /////////////////////////////////////////////
                echo "success";
            }
        } else {
            echo "incorrect";
        }
    }
    
?>