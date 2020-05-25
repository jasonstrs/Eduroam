<?php
    session_start();
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    
if(!($action = valider("action","POST"))){
    header("Location:../index.php?view=accueil");
}



if( !($idU = valider("idUser","SESSION")))die("Non connecte");
$hash = valider("hash","SESSION");
if(!isSuperAdmin($idU,$hash) && !getDroitByUser($idU,"utilisateurs"))die("Pas les droits");

switch($action){

	case 'add' : 
        $nom = valider("nom", "POST");
        $droits = valider("droits", "POST");
        echo addRole($nom, $droits);
    break;
    case 'delete' : 
        $idRole = valider("idRole", "POST");
        deleteRole($idRole);
    break;
    case 'edit' : 
        $idRole = valider("idRole", "POST");
        $nom = valider("nom", "POST");
        $droits = valider("droits", "POST");
        editRole($idRole, $nom, $droits);
    break;
}


?>