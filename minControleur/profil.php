<?php
    session_start();
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    

    if(!($action = valider("action"))){
        header("Location:../index.php?view=accueil");
        die("");
    }
    
    switch($action){
        case 'getParams' :
            $id = valider('idUser','SESSION');
            $tab=array();
            $prenom = getPrenom($id);
            $nom = getNom($id);
            array_push($tab,$prenom);
            array_push($tab,$nom);
            array_push($tab,valider("email","SESSION"));
            echo (json_encode($tab));
        break;
    }

?>