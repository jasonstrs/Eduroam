<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";
   include_once "../libs/maLibPHPMailer.php";
   
    if (valider("email") && valider("passe") && valider("checked")){ // on vérifie que toutes les valeurs sont définies
        $email = valider('email');
        $passe = sha1(md5(valider('passe')));
        $check = valider("checked");

        $aux = verifUser($email,$passe,$check); // verifie si l'utilisateur est dans la bdd et si il a confirmé son mail
                                                // on peut aussi savoir si on garde l'utilisateur en cookie
        echo $aux;
    }
    
?>