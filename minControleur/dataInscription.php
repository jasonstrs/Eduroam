<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";

    
    if (valider("email","POST") && valider("passe","POST") && valider("nom","POST") && valider("prenom","POST")){
        $email = valider("email","POST");
        $passe = sha1(md5(valider("passe","POST")));
        $nom = valider("nom","POST");
        $prenom=valider("prenom","POST");
        
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