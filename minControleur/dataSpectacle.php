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
            if(!($nom = valider("nom")))$nom="";
            echo json_encode(selectVilles($nom));
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
                echo false;
            }
            
        break;
        case "ajouterDates":
            /**
             * Si $nouv == 0, on va ajouter une date à un spectcle existant
             * Si $nouv == 1, on va céer un spectacle
             * Pour le savoir, on  vérifie si l'idSpectacle renvoyé n'est pas null
             */
            $nouv = 0;
            if(!($dates = valider("dates","POST"))){
                header("Location:../index.php?view=planiSpectacle");
                die("");
            }
            if(!($idSpec = valider("idSpectacle","POST")))$nouv = 1;
            if($nouv == 0){
                //Si on ajoute une date à un spectacle existant

            }
            else{
                //Si on crée entièrement un spectacle
                if($ville = valider("ville","POST"))
                if($desc = valider("desc","POST")){
                   $idSpec = creerSpectacle($ville,$desc); //On crée le spectacle et on récupère son id
                }
            }
            foreach($dates as $currDate){
                if($currDate != "")
                    echo "ID ajout : ".ajouterDateSpectacle($idSpec,$currDate);
            }
        break;
        case "supprDate":
            if($date  = valider("idDate","POST"))
                supprimerDate($date);
        break;
        case "supprSpectacle":
            if($date  = valider("id","POST"))
                supprimerSpectacle($date);
        break;
        case "validDate":
            if(!($lien = valider("lien","POST")))$lien = "";
            if($date  = valider("idDate","POST"))
                validerDate($date,$lien);
        break;
        case "nbDates":
            $tab = array();
            if($valid = valider("val","POST")){
                if($valid==2)$valid=0;
                $tab["rep"] = nbDates($valid);
                $tab["valid"]=$valid;
                echo(json_encode($tab));
            }
        break;
        case "nbDatesUser":
            $tab = array();
            if($choix = valider("val","POST"))
            if($idU = valider("idU","POST")){
                $tab["rep"] = nbDatesUser($choix,$idU);
                $tab["valid"]=intval($choix);
                echo(json_encode($tab));
            }
        break;
        case "chargerDates":
            $tab = array();
            if(!($tri = valider("tri","POST")))$tri = "nbInscrits";
            if($valid = valider("val","POST")){
                if($valid==2)$valid=0;
                $tab["rep"] = chargerDates($valid,$tri);
                foreach($tab["rep"] as $key => $date){
                    $tab["rep"][$key]["nbInscrits"] = nbInscritsDate($date["idDate"]);
                }  
                if($tri == "nbInscrits"){
                    //On trie le tableau en fonction du nombre d'inscrits
                    function cmp($a, $b){
                        if ($a['nbInscrits']>$b['nbInscrits']) {
                            return -1;
                        }
                        return 1;
                    }
                    usort($tab["rep"],'cmp');  
                }    
                $tab["valid"]=$valid;
                echo(json_encode($tab));
            }
        break;
    }
    
    
?>