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
    
    $id = valider("idUser","SESSION");

    switch($action){
        case 'getParams' :
            $tab=array();
            $prenom = getPrenom($id);
            $nom = getNom($id);
            array_push($tab,$prenom);
            array_push($tab,$nom);
            array_push($tab,valider("email","SESSION"));
            echo (json_encode($tab));
        break;

        case 'mot de passe' :
            $pass = sha1(md5(valider("contenu","POST")));
            changePass($id,$pass);
            echo 'Success';
        break;

        case 'prénom' :
            $prenom = valider("contenu","POST");
            changeFirstName($id,$prenom);
            echo 'Success';
        break;

        case 'nom' :
            $nom = valider("contenu","POST");
            changeName($id,$nom);
            echo 'Success';
        break;

        default :
            echo "ERROR";
    }

?>