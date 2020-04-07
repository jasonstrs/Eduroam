<?php
    /* session_start(); */
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    
if(!($action = valider("action","POST"))){
    header("Location:../index.php?view=accueil");
}

$action = valider("action","POST");
switch($action){

    case 'search' : 
        $tag = valider("tag","POST");
        echo json_encode(searchUsersByTag($tag));
    break;
}


?>