<?php
session_start();
include_once "../libs/maLibUtils.php";
include_once "../libs/maLibSQL.pdo.php";
include_once "../libs/maLibSecurisation.php";
include_once "../libs/modele.php";

if(!($action = valider("action","POST"))){
		header("Location:../index.php?view=accueil");
}

$action = valider("action","POST");
switch($action){

    case 'addAnnonce' : 
        $contenu = valider("contenu","POST");
        if(valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce")) addAnnonce($contenu, valider("idUser","SESSION"));
    break;

    case 'editAnnonce' : 
        $contenu = valider("contenu","POST");
        $id = valider("id","POST");
        echo $id;
        if(valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce")) editAnnonce($id, $contenu);
    break;

    case 'addSondage' : 
        if(valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce"))
        {
            $intitule = valider("intitule","POST");
            $reponses = valider("reponses","POST");
            $hideResult = valider("hideResult","POST");
            if(valider("dateEnd","POST")) $dateEnd = date("Y-m-d",strtotime(valider("dateEnd","POST")));
            else $dateEnd = "null";
            $sondage = addSondage($intitule, valider("idUser","SESSION"), $hideResult, $dateEnd);
            foreach ($reponses as $reponse) {
                addChoix($sondage, $reponse);
            }
        }
    break;

    case 'vote' : 
        $idSondage = valider("idSondage","POST");
        $idChoix = valider("choix","POST");
        if(!hasVoted(valider("idUser","SESSION"), $idSondage))
            addVote(valider("idUser","SESSION"), $idChoix);
        $results = array(getReponseCountBySondage($idSondage));
        $choix = getChoix($idSondage);
        foreach($choix as $rep) {
            array_push($results, getReponseCountByChoix($rep["idChoix"]));
        }
        echo json_encode($results);
    break;

    case 'suppr' : 
        $idAnnonce = valider("idAnnonce","POST");
        if(valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce")) removeAccueil($idAnnonce);
    break;

    case 'getRandomVideo' : 
        $randomVideo = getRandomVideo();
        echo json_encode($randomVideo);
    break;
    
}



?>