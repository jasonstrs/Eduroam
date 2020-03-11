<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
}

if (valider("connecte","SESSION") && valider("admin","SESSION")==1) {?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="spectacle-tab" data-toggle="tab" href="#spectacle" role="tab" aria-controls="spectacle" aria-selected="true">Spectacle</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="role-tab" data-toggle="tab" href="#role" role="tab" aria-controls="role" aria-selected="false">Rôles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="false">Utilisateurs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">Vidéos</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="spectacle" role="tabpanel" aria-labelledby="spectacle-tab">
        <?php include("planiSpectacles.php"); ?>
    </div>
    <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
        <?php include("role.php"); ?>
    </div>
    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">...</div>
    <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">...</div>
</div>

<?php } else {
echo "Vous n'avez pas accés à cette page";
} ?>