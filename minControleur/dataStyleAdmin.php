<?php   
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    include_once "../libs/maLibMails.php";
    session_start();

    //echo tprint($_FILES);

    if(!($idU = valider(("idUser"),"SESSION")))die("Non connecté");
    $hash = valider(("hash"),"SESSION");

    if(!isSuperAdmin($idU,$hash))die("Tentative d'accès à une fonction admin");
    
    if(!($action = valider("action"))){
        header("Location:../index.php?view=accueil");
        die("");
    }

    switch($action){
        case "uploadFondEcran":
            if(isset($_FILES["fic"]) && !empty($_FILES["fic"])){
                $fic = $_FILES["fic"];
                //tprint($fic);

                $tmp = $fic["tmp_name"];
                $nom = "backImageTmp";
                if(copy($tmp,"../ressources/backImg/$nom"))echo("1");
                else echo "erreur lors du transfert du fichier";
            }
            else("Erreur lors de l'envoi du fichier au serveur");
        break;
        case "validerChange":
            if(isset($_POST["json"]) && !empty($_POST["json"])){
                $json = $_POST["json"];

                $json = json_encode($json);

                $fName = "../ressources/style.json";
                $myfile = fopen($fName, "w") or die("Impossible d'ouvrir le fichier ! ");

                fwrite($myfile, $json);

                if(file_get_contents($fName) == $json)$success=1;
                else $success = "Erreur lors de l'écriture du fichier de configuration.";

                fclose($myfile);

                echo $success;
                if(file_exists("../ressources/backImg/backImageTmp")){

                    rename("../ressources/backImg/backImageTmp","../ressources/backImg/backImage");

                }
                else{


                }
            }
            else echo "Erreur lors de la transmission des donnees";
        break;
    }



?>