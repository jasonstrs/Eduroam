<?php
// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
}

if (valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "spectacle")
|| getDroitByUser(valider("idUser","SESSION"), "utilisateurs") || getDroitByUser(valider("idUser","SESSION"), "video"))) {

  lireInfos();
?>
<link rel="stylesheet" type="text/css" href="./css/admin.css"/>
<div class="containerAdmin">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php if(getDroitByUser(valider("idUser","SESSION"), "spectacle") || valider("admin","SESSION")==1) { ?>
        <li class="nav-item">
            <a class="nav-link" id="creerSpectacles-tab" data-toggle="tab" href="#creerSpectacles" role="tab" aria-controls="creerSpectacles" aria-selected="true">Création des Spectacles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="statsSpectacles-tab" data-toggle="tab" href="#statsSpectacles" role="tab" aria-controls="statsSpectacles" aria-selected="false">Statistiques des Spectacles</a>
        </li>
        <?php } ?>
        <?php if(getDroitByUser(valider("idUser","SESSION"), "utilisateurs") || valider("admin","SESSION")==1) { ?>
        <li class="nav-item">
            <a class="nav-link" id="role-tab" data-toggle="tab" href="#role" role="tab" aria-controls="role" aria-selected="false">Rôles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Utilisateurs</a>
        </li>
        <?php } ?>
        <?php if(getDroitByUser(valider("idUser","SESSION"), "video") || valider("admin","SESSION")==1) { ?>
        <li class="nav-item">
            <a class="nav-link" id="videos-tab" data-toggle="tab" href="#videos" role="tab" aria-controls="videos" aria-selected="false">Vidéos</a>
        </li>
        <?php } ?>
    </ul>
    <div class="tab-content" id="myTabContent">
        <?php if(getDroitByUser(valider("idUser","SESSION"), "spectacle") || valider("admin","SESSION")==1) { ?>
        <div class="tab-pane fade" id="creerSpectacles" role="tabpanel" aria-labelledby="creerSpectacles-tab">
            <?php include("creerSpectacles.php"); ?>
        </div>

        <div class="tab-pane fade" id="statsSpectacles" role="tabpanel" aria-labelledby="statsSpectacles-tab">
            <?php include("statsSpectacles.php"); ?>
        </div>
        <?php } ?>

        <?php if(getDroitByUser(valider("idUser","SESSION"), "utilisateurs") || valider("admin","SESSION")==1) { ?>
        <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
            <?php include("role.php"); ?>
        </div>

        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            <?php include("users.php"); ?>
        </div>
        <?php } ?>

        <?php if(getDroitByUser(valider("idUser","SESSION"), "video") || valider("admin","SESSION")==1) { ?>
        <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
            <?php include("videoAdmin.php"); ?>
        </div>
        <?php } ?>
    </div>
</div>

<?php } else {
echo "Vous n'avez pas accés à cette page";
} 

if($volet = valider("volet","GET")){
    ?>
    <script>
        $("#containerAdmin").ready(function(){
            var volet='<?=$volet?>';
            console.log(volet);
            $(".nav-link").removeClass('active');
            $(".tab-pane").removeClass('show').removeClass("active");
            $("#"+volet+"-tab").addClass("active");
            $("#"+volet).addClass("show active");
        });
            
    </script>
    <?php

}
else{
    ?>
    <script>
        $("#containerAdmin").ready(function(){
            var volet='<?=$volet?>';
            console.log(volet);
            $(".nav-link").removeClass('active');
            $(".tab-pane").removeClass('show').removeClass("active");
            $("#creerSpectacles-tab").addClass("active");
            $("#creerSpectacles").addClass("show active");
        });
            
    </script>
    <?php
}

?>
<script>
$(".nav-link").click(function(){
    var id=$(this).attr("id");
    idPanneau = id.substring(0,id.length-4);
    history.pushState('','','index.php?view=admin&volet='+idPanneau);
});
</script>