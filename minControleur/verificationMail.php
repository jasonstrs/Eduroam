<?php
include_once "../libs/maLibUtils.php";
include_once "../libs/maLibSQL.pdo.php";
include_once "../libs/maLibSecurisation.php";
include_once "../libs/modele.php";
include_once "../libs/maLibPHPMailer.php";

$flag=0;

if (valider("newP","POST")){
    $flag=1;
    $newPasse = valider("newP","POST");
    //die($newPasse);
}

if (valider("confirm","GET"))
    $flag=1;

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
        $id = getIdViaHash($hash);
        $add="pass";
        if ($id){
            if ($flag){
                $qs="success";
                changePass($id,sha1(md5("NEW PASSE")));
            } else
                newPasse($hash);
        } else {
            $qs="fail";
            $flag=1;
        }
    break;
}

if ($flag)
    header("Location:../index.php?view=login&".$add."=".$qs); // sinon on renvoie


?>