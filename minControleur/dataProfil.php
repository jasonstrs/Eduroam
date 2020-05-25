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
    
    if( !($id = valider("idUser","SESSION")))die("Non connecté");

    switch($action){
        case 'getParams' :
            $tab=array();
            $prenom = getPrenom($id);
            $nom = getNom($id);
            $choice = getChoice($id);
            array_push($tab,$prenom);
            array_push($tab,$nom);
            array_push($tab,valider("email","SESSION"));
            array_push($tab,$choice);
            echo (json_encode($tab));
        break;

        case 'mot de passe' :
            if(preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$#i",valider("contenu","POST"))){
                $pass = sha1(md5(valider("contenu","POST")));
                changePass($id,$pass);
                echo 'Success';
            } else
                echo "Error";
            
        break;

        case 'changeValue' :
            $choice = valider("choice","POST");
            changeValue($id,$choice);
            echo 'Success';
        break;

        case 'prénom' :
            if (preg_match("#^[a-zâäàéèùêëîïôöçñ \-]+$#i",valider("contenu","POST"))){
                $prenom = valider("contenu","POST");
                changeFirstName($id,$prenom);
                echo 'Success';
            } else 
                echo 'Error';
        break;

        case 'nom' :
            if (preg_match("#^[a-zâäàéèùêëîïôöçñ \-]+$#i",valider("contenu","POST"))){
                $nom = valider("contenu","POST");
                changeName($id,$nom);
                echo 'Success';
            } else
                echo 'Error';
        break;

        case "modifNbJoursMail":
            $rep=array();
            if($val = valider("nb","POST"))
            if($idU = valider("idU","POST")){

                if($val>14 || $val<1){
                    $rep["success"]=false;
                    $rep["erreur"]="Valeur entrée incorrecte";
                    echo json_encode($rep);
                    return;
                }
                
                $res = modifNbJoursMail($val,$idU);
                if($res == 1 && getNbJoursMail($idU) == $val)$rep["success"]="1";
                else $rep["success"]="0";
                echo json_encode($rep);
            }
        break;

        default :
            echo "ERROR";
    }

?>