<?php
// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
}

if (valider("connecte","SESSION") && valider("admin","SESSION")==1) {?>
<link rel="stylesheet" type="text/css" href="./css/admin.css"/>
<div class="containerAdmin">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="gererSpectacles-tab" data-toggle="tab" href="#gererSpectacles" role="tab" aria-controls="gererSpectacles" aria-selected="true">Gestion des Spectacles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="statsSpectacles-tab" data-toggle="tab" href="#statsSpectacles" role="tab" aria-controls="statsSpectacles" aria-selected="false">Statistiques des Spectacles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="role-tab" data-toggle="tab" href="#role" role="tab" aria-controls="role" aria-selected="false">Rôles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="videos-tab" data-toggle="tab" href="#videos" role="tab" aria-controls="videos" aria-selected="false">Vidéos</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="gererSpectacles" role="tabpanel" aria-labelledby="gererSpectacles-tab">
            <?php include("planiSpectacles.php"); ?>
        </div>

        <div class="tab-pane fade" id="statsSpectacles" role="tabpanel" aria-labelledby="statsSpectacles-tab">
            <?php include("statsSpectacles.php"); ?>
        </div>

        <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
            <?php include("role.php"); ?>
        </div>

        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            <?php include("users.php"); ?>
        </div>
        <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
           qsdqsdz
        </div>
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
            $("#gererSpectacles-tab").addClass("active");
            $("#gererSpectacles").addClass("show active");
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