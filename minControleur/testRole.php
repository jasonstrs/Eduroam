<?php
    /* session_start(); */
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    

/*     if(!($action = valider("action"))){
        header("Location:../index.php?view=accueil");
        die("");
    } */
    
    $nom = valider("nom", "POST");
    $droits = valider("droits", "POST");

    print_r($droits);

    addRole($nom, $droits);

?>