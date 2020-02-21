<?php
include_once "../libs/maLibUtils.php";
include_once "../libs/maLibSQL.pdo.php";
include_once "../libs/maLibSecurisation.php";
include_once "../libs/modele.php";
include_once "../libs/maLibPHPMailer.php";

$flag=0;

if (valider("form","POST")){
    $flag=1; // on a lancé le form
    $newPasse = valider("newP","POST"); // on récupère les MDP
    $newPasseBis = valider("newPbis","POST");
}

if (valider("action","GET")) {
    if (valider("action","GET") == "verificationMail" || valider("action","GET") == "verificationPassword"){
        $action = valider("action","GET");
        $hash = valider("hash","GET");
    }
    else
        header("Location:../index.php?view=accueil"); // sinon on renvoie
}

$qs ="";
$add="";

switch($action){
    case 'verificationMail' :
        // on regarde si le hash correspond bien à un utilisateur
        // sinon on écrit page inconnu
        $id = getIdViaHash($hash);
        $add="mail";
        
        if ($id){
            confirmAdress($id);
            $qs="success";
        } else {
            $qs="fail";
        }
        $flag=1;
       
    break;

    case 'verificationPassword' : 
        $id = getIdViaHash($hash); // on regarde si le hash est correct
        $add="pass"; // on s'occupe du cas 'pass'
        if ($id){ // si on a récupéré l'ID
            if ($flag){ // si le form a déjà été lancé et qu'on a récupéré les MDP
                if (preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$#",$newPasse)){ // on teste si le MDP respecte la norme
                    if ($newPasse == $newPasseBis) { // on teste si les deux MDP sont identiques
                        changePass($id,sha1(md5($newPasse)));
                        $qs="success";
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\" style='text-align:center;'>
                            Saisir un mot de passe identique.</div>";
                        $flag=0;
                        newPasse($hash);
                    }
                } else { // sinon on ne respecte pas le format de MDP
                    echo "<div class=\"alert alert-danger\" role=\"alert\" style='text-align:center;'>
                    Saisir un mot de passe correct (8 caractères minimum dont 1 majuscule, 1 minuscule et 1 chiffre).
                    </div>";
                    $flag=0;
                    newPasse($hash);
                }
            } else // on lance la fonction car premier clic sur le lien
                newPasse($hash);
        } else { // probleme de HASH
            $qs="fail";
            $flag=1;
        }
    break;
}

if ($flag)
    header("Location:../index.php?view=login&".$add."=".$qs); // sinon on renvoie


?>