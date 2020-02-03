<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";

    
    if (valider("email") && valider("passe") && valider("nom") && valider("prenom")){
        $email = valider("email");
        $passe = sha1(md5(valider("passe")));
        $nom = valider("nom");
        $prenom=valider("prenom");
        
        if (verifExistMail($email)){
            echo "Exist";
        } else {
            $hashCode = md5(uniqid(rand(), true));
            $id =createUser($email,$nom,$prenom,$passe,$hashCode);
            
            // on envoie un mail : A AJOUTER
            echo "Success";
        }   
    }
?>