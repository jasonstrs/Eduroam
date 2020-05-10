<?php
include_once "./libs/maLibUtils.php";
include_once "./libs/maLibSQL.pdo.php";
include_once "./libs/maLibSecurisation.php";
include_once "./libs/modele.php";
include_once "./libs/maLibPHPMailer.php";

echo "<link href='bootstrap/css/bootstrap.css' rel='stylesheet' />";
echo "<script src=\"bootstrap/js/bootstrap.js\"></script>";

// Variable qui va permettre d'envoyer les mails
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST']; 

$flag=0;


if (valider("action","GET")) {
    if (valider("action","GET") == "verificationMail" || valider("action","GET") == "verificationPassword"){
        $action = valider("action","GET");
        $hash = valider("hash","GET");
    }
    else
        header("Location:../index.php?view=accueil"); // sinon on renvoie
} else {
    die("Un problème est survenu ! Veuillez contacter la maintenance.");
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
            changeHash($hash,$id,md5(uniqid(rand(), true)));
        } else {
            $qs="fail";
        }
        $flag=1;
       
    break;

    case 'verificationPassword' : 
        $id = getIdViaHash($hash); // on regarde si le hash est correct
        $add="pass"; // on s'occupe du cas 'pass'
        if ($id){ // si on a récupéré l'ID
           
            session_start();
            $_SESSION['hashModifPass']=$hash;
            
            header("Location:../ig2i-projet-Eduroam/index.php?view=changementPasse");

        } else { // probleme de HASH
            $qs="fail";
            $flag=1;
        }
    break;
}

if ($flag)
    header("Location:". $url ."/ig2i-projet-Eduroam/index.php?view=login&".$add."=".$qs); // sinon on renvoie


?>