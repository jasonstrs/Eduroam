<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";
   include_once "../libs/maLibPHPMailer.php";
   
    if (valider("email","POST") && valider("passe","POST") && valider("checked","POST")){ // on vérifie que toutes les valeurs sont définies
        $email = valider('email',"POST");
        $passe = sha1(md5(valider('passe',"POST")));
        $check = valider("checked","POST");

        $aux = verifUser($email,$passe,$check); // verifie si l'utilisateur est dans la bdd et si il a confirmé son mail
                                                // on peut aussi savoir si on garde l'utilisateur en cookie
        echo $aux;
    }
    
?>