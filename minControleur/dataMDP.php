<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";
   include_once "../libs/maLibPHPMailer.php";
   
    if (valider("email","POST")){ // on vérifie que toutes les valeurs sont définies
        $email = valider('email',"POST");
        if (verifExistMail($email)){ // l'adresse est existante
           
                // ici on envoie un mail pour récup le mdp /////////////////////////////////////////////
            echo "success";
        } else {
            echo "incorrect";
        }
    }
    
?>