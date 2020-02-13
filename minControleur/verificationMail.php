<?php
include_once "../libs/maLibUtils.php";
include_once "../libs/maLibSQL.pdo.php";
include_once "../libs/maLibSecurisation.php";
include_once "../libs/modele.php";
include_once "../libs/maLibPHPMailer.php";

if (valider("action","GET")) {
    if (valider("action","GET") == "verificationMail"){
        $action = valider("action","GET");
        $hash = valider("hash","GET");
    }
    else
        header("Location:../index.php?view=accueil"); // sinon on renvoie
}

$qs ="";

switch($action){
    case 'verificationMail' :
        // on regarde si le hash correspond bien à un utilisateur
        // sinon on écrit page inconnu
        $id = getIdViaHash($hash);
        
        if ($id){
            confirmAdress($id);
            $qs="success";
        } else {
            $qs="fail";
        }
       
    break;
}

header("Location:../../index.php?view=login&mail=".$qs); // sinon on renvoie


?>