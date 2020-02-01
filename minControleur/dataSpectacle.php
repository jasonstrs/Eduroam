<?php   
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";


    if(!($action = valider("action"))){
        header("Location:../index.php?view=accueil");
        die("");
    }
    switch($action){
        /**
         * Va chercher dans la BDD les villes qui ont été proposées pour un spectacle
         */
        case "chargerVilles" :
            echo json_encode(selectVilles());
        break;
        case "verifVilleNom":
            $tab = array();
            
            if($nom = valider("nom"))
            {
                array_push($tab,$nom);
                array_push($tab,verifVilleNom($nom));
                echo(json_encode($tab));
            }
            else{
                echo 0;
            }
            
        break;
    }
    
    
?>