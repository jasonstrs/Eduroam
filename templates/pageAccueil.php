<?php
    session_start();
    include_once "../libs/modele.php";
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    $page=valider("page");
    $accueils = getAccueils($page*5);
    $firtAnnonce = true;
    foreach($accueils as $accueil) {
        if($accueil["type"]=="annonce") { 
            $annonce = getAnnonceById($accueil["id_annonce"]);
            ?>
            <div class="unArticle <?php if($firtAnnonce) echo "pt-1" ?>" id="annonce<?php echo $annonce[0]["idArticle"]; ?>">
                <?php echo htmlspecialchars_decode($annonce[0]["contenu"]); ?>
                <div style="text-align:left;">
                    <?php if (valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce"))) { ?>
                    <span class="admin">
                        <a id="suppr<?php echo $accueil["id"]?>" href="#confirmSupprModal" data-toggle="modal" class="suppr">Supprimer</a>
                        - 
                        <a href="index.php?view=editArticle&id=<?php echo $accueil["id_annonce"]?>">Modifier</a>
                        -
                        <i class="fas fa-thumbtack epingle <?php if(GetEpingle($accueil["id_annonce"])) echo(' estEpingle') ?>" id=epinlge<?php echo $accueil["id_annonce"]; ?>></i>
                    </span>
                    <?php } ?>
                    <span class="date">Publié le <?php echo date("d/m/Y",strtotime($annonce[0]["dateArticle"])); ?></span>
                </div>
            </div>
        <?php }
        else if($accueil["type"]=="sondage") { 
            $sondage = getSondageById($accueil["id_annonce"]);
            $choix = getChoix($accueil["id_annonce"]);
            $date1 = new DateTime("now");
            $date2 = new DateTime($sondage[0]["dateFin"]);
            $strDate2 = $date2->format("d/m/Y");
            $first = true;
            $total = getReponseCountBySondage($accueil["id_annonce"]);
            ?>
            <div class="unSondage <?php if($firtAnnonce) echo "pt-1" ?>">
                <div class="card-header"><?php 
                    if(valider("connecte","SESSION"))echo $sondage[0]["intitule"]."<font size='-1'> - ".GetNbRepSondage($sondage[0]["idSondage"])." réponse(s)</font>"; 
                    else echo $sondage[0]["intitule"]." <span style='color:darkgrey;'>- Connectez-vous pour répondre à ce sondage.</span>";
                
                if($date1>$date2) echo "<span class='fermer'> - Ce sondage est fermé depuis le $strDate2 </span>";
                ?></div>
                
                <input type="hidden" id="hidden<?php echo $sondage[0]["idSondage"];?>" value="<?php echo $sondage[0]["cacherResultats"]; ?>" >
                <div id="reponse<?php echo $sondage[0]["idSondage"]; ?>" class="card-body text-dark">
                    <?php foreach($choix as $rep) { ?>
                    <div class="reponse">
                        <?php if(valider("connecte","SESSION") && (!hasVoted(valider("idUser","SESSION"), $sondage[0]["idSondage"]) && $date1<$date2)) {
                            //Si on est connecté et que l'on a pas voté ?>
                            <div class="form-check" id="choix<?php echo $rep["idChoix"]; ?>">
                                <input name="<?php echo $sondage[0]["idSondage"]; ?>" class="form-check-input" type="radio" id="check<?php echo $rep["idChoix"]; ?>" <?php if($first) echo "checked"; ?>>
                                <label class="form-check-label" for="check<?php echo $rep["idChoix"]; ?>">
                                    <?php echo $rep["choix"]; ?>
                                </label>
                            </div>
                        <?php }
                        else if(!valider("connecte","SESSION") && $date1<$date2) { 
                            //Si on est pas connecté?>
                            <div class="form-check" id="choix<?php echo $rep["idChoix"]; ?>">
                                <input name="<?php echo $sondage[0]["idSondage"]; ?>" class="form-check-input" type="radio" id="check<?php echo $rep["idChoix"]; ?>" <?php if($first) echo "checked"; ?> disabled>
                                <label class="form-check-label" for="check<?php echo $rep["idChoix"]; ?>">
                                    <?php echo $rep["choix"]; ?>
                                </label>
                            </div>
                        <?php } else {?>
                            <div>
                                <?php echo $rep["choix"]; ?>
                            </div>
                        <?php } ?>
                        <?php if($sondage[0]["cacherResultats"]!=1 || (valider("connecte","SESSION") && hasVoted(valider("idUser","SESSION"), $sondage[0]["idSondage"])) || $date1>$date2) {
                            $nbVote = getReponseCountByChoix($rep["idChoix"]);
                            if($nbVote==0 || $total==0) $pourcentage=0;
                            else $pourcentage= round(($nbVote/$total)*100);
                            ?>
                            <div class="progress">
                                <?php if($pourcentage ==0) echo "<span style='margin-left:20px; color: #fff;'>".$pourcentage."%</span>"?>
                                <?php echo '<div class="progress-bar bg-warning" role="progressbar" style="width:'.$pourcentage.'%;" aria-valuenow="?><?php echo $pourcentage" aria-valuemin="0" aria-valuemax="100">'?><?php if($pourcentage !=0) echo $pourcentage."%"?></div>
                            </div>
                        <?php }
                        $first = false; ?>
                    </div>
                    <?php } ?>
                    <br/>	
                    <?php if(valider("connecte","SESSION") && !hasVoted(valider("idUser","SESSION"), $sondage[0]["idSondage"]) && $date1<$date2) { ?>
                        <input id="soumettre<?php echo $sondage[0]["idSondage"]; ?>" type="submit" class="btn btn-warning offset-9 soumettre" name="action" value="Répondre au sondage"/>
                    <?php } ?>
                    <div style="text-align:left;">
                        <?php if (valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce"))) { ?>
                        <span class="admin">
                            <a id="suppr<?php echo $accueil["id"]?>" href="#confirmSupprModal" data-toggle="modal" class="suppr">Supprimer</a>
                             - 
                            <i class="fas fa-thumbtack epingle <?php if(GetEpingle($accueil["id_annonce"])) echo(' estEpingle') ?>" id=epinlge<?php echo $accueil["id_annonce"]; ?>></i>
                        </span>
                        <?php } ?>
                        <span class="date">Publié le <?php echo date("d/m/Y", strtotime($sondage[0]["date"])); ?></span>
                    </div>
                </div>
            </div>
        <?php }
        $firtAnnonce = false;
    }
?>