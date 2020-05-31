<?php   
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    include_once "../libs/maLibMails.php";
    session_start();

    if(!($action = valider("action"))){
        header("Location:../index.php?view=accueil");
        die("");
    }
    if(!($idU = valider(("idUser"),"SESSION")))die("Non connecté");
    $hash = valider(("hash"),"SESSION");
    //die($idU);

    /**
     * Fonction administrateur
     */
    if(getDroitByUser($idU, "spectacle") || isSuperAdmin($idU,$hash)){
        switch($action){
            /**
             * Va chercher dans la BDD les villes qui ont été proposées pour un spectacle
             */
            case "chargerVilles" :
                if(!($nom = valider("nom")))$nom="";
                $rep = selectVilles($nom);            
                echo json_encode($rep);
            break;
            /**
             * On vérifie si la ville entrée est dans la BDD
             */
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
                if(!isset($_POST["dates"]) || empty($_POST["dates"])){
                    header("Location:../index.php?view=creerSpectacle");
                    die("Dates entrées incorrectes");
                }
                $dates = $_POST["dates"];
                if(!($idSpec = valider("idSpectacle","POST")))$nouv = 1;
                if($nouv != 0){            
                    //Si on crée entièrement un spectacle
                    if($ville = valider("ville","POST"))
                    if($desc = valider("desc","POST")){
                    $idSpec = creerSpectacle($ville,$desc); //On crée le spectacle et on récupère son id
                    }
                }
                $i=0;
                foreach($dates as $currDate){
                    if($currDate != "")
                        if(ajouterDateSpectacle($idSpec,$currDate))$i++;
                }
                //On renvoie le nombre de modifications
                echo $i;
            break;
            case "supprDate":
                if($date  = valider("idDate","POST"))
                    supprimerDate($date);
                else 
                    echo 0;
            break;
            case "supprSpectacle":
                if($spec  = valider("id","POST")){
                    $rep = supprimerSpectacle($spec);
                    echo $rep;
                }
            break;
            case "archiverDate":
                if($date  = valider("idDate","POST"))
                    echo archiverDate($date);
            break;
            case "validDate":
                if(!($lien = valider("lien","POST")))$lien = "";
                if($date  = valider("idDate","POST")){
                    $rep = array();
                    $valide = validerDate($date,$lien);
                    if($valide == 0){
                        $rep["success"]=$valide;
                        echo json_encode($rep);
                        return;
                    }
                    $tabUsers = trouverUsersDateValidee($date);
                    $i=0;
                    foreach($tabUsers as $user){
                        if(mailSpectacleValide($user))
                            $i++;
                    }
                    $rep["nbMails"] = $i;
                    $rep["success"] = $valide;
                    echo json_encode($rep);
                }
            break;
            case "modifLien":
                if($lien = valider("valeur"))
                if(isset($_POST['prev_val']))
                    if($idDate = valider("idDate")){
                        $prev = $_POST["prev_val"];
                        modifLien($idDate,$lien);
                        $rep = array();
                        $rep["ancien"] = $prev;
                        $rep["nouveau"] = $lien;
                        echo json_encode($rep);

                    }
            break;
            case "suppDatesPassees":
                $today = date("Y-m-d");
                $tab = recupToutesLesDates();
                $i=0;
                foreach ($tab as $value) {
                    if($value["dateSpectacle"]<$today){
                        supprimerDate($value["idDate"]);
                        $i++;
                    }
                }
                echo $i;
            
            break;
        }
        
    }
    if(valider("idUser","SESSION")){
            /**
             * Fonctions utilisateur
             */
        switch($action){
            case "nbDates":
                $tab = array();
                if($valid = valider("val","POST")){
                    $tab["rep"] = nbDates($valid);
                    $tab["valid"]=$valid;
                    echo(json_encode($tab));
                }
            break;
            case "nbDatesUser":
                $tab = array();
                if(!($ville = valider("ville","POST")))$ville="";
                if($choix = valider("val","POST"))
                if($idU = valider("idU","POST")){
                    $tab["rep"] = nbDatesUser($choix,$idU,$ville);
                    $tab["valid"]=$choix;
                    echo(json_encode($tab));
                }
            break;
            case "chargerDates":
                $tab = array();

                //Tri par nombre d'inscrits par défaut
                if(!($tri = valider("tri","POST")))$tri = "nbInscrits";
                if(!($idU = valider("idU","POST")))$id=false;
                if(!($ville = valider("ville","POST")))$ville="";
                //Si on a une valeur de valid
                if($valid = valider("val","POST")){
                    $tab["rep"] = chargerDates($valid,$tri,$idU,$ville);
                    foreach($tab["rep"] as $key => $date){
                        $tab["rep"][$key]["nbInscrits"] = nbInscritsDate($date["idDate"]);
                    }  
                    
                    //tri du tableau ssi on veut le rier par nb d'inscrits
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
            case "userInteresseDates":
                $rep = array();
                $rep["choix"] = 0;
                if($idU = valider("idU","POST"))
                if($choix = valider("valeur","POST"))
                if(isset($_POST["dates"]) && !($_POST["dates"] == "")){
                    $rep["choix"] = $choix;
                    $dates = $_POST["dates"];
                    $rep["nb"] = userInteresseDates($choix,$idU,$dates);
                }
                echo json_encode($rep);
            
            break; 
        }
    }
    else{
        die("Vous n'etes pas connecté");
    }
       
?>