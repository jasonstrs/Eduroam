<?php
    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }
    if(valider("view","GET")=="planiSpectacles") {
        echo "Vous n'avez pas accés à cette page";
    } else {
?>
<link rel="stylesheet" type="text/css" href="./css/spectacle.css"/>
<script src='js/creerSpectacles.js'></script>
<h3>
    <div id="titre">
        Gestion des spectacles
    </div>
</h3>

<div class="lead">
    <div id="entrerVille">
        <span class="gras">Entrer une ville où créer un Spectacle : </span><br>
        <?php 
            mkInput("text","nomVille","","placeholder='Entrer le nom de la ville' class='form-control' id='champTxtVille'");
        ?>
        <button id="validerEntreeVille" class="btn btn-outline-primary" style="margin-bottom:3px;">Valider</button>
        <img class="loader" src="./ressources/loading.gif" style="width:50px;display:none;"/>
    </div>
    <div id="listeVilles">
        <span class="gras">Spectacles en attente :</span>
            Cliquez pour afficher toutes les dates.
        <br>
    
        <script>
            chargerVilles();
        </script>
        
    </div> 
    <div id="choisirDates">
        <br><span class="gras"></span>
        <?php
            echo "Ville : ";
            mkInput("text","nomVilleBis",""
            ,"placeholder='Entrer le nom de la ville' class='form-control champNomDesc' id='champTxtVilleBis'");
            echo "Description du spectacle : ";
            mkInput("text","descSpec",""
            ,"placeholder='Entrer la description du spectacle' class='form-control champNomDesc' id='champTxtDescSpectacle'");
        ?>
            <!-- <button type="button" id="boutonSelectDates" class="btn btn-outline-primary methodeChoixDates" disabled>Selectionner des dates</button> -->
            <div class="btn-group" role="group" aria-label="Basic example" id="groupSelectDates">
                <button type="button" class="btn btn-outline-primary" value="select1by1">Sélectionner des dates une par une</button>
                <button type="button" class="btn btn-outline-primary" value="selectPas">Sélectionner un début, une fin, un pas</button>
            </div>
            <br><div id="selectionDesDates"></div>
            <br><button type="button" id="boutonValiderDates" class="btn btn-outline-primary methodeChoixDates" data-toggle="modal" data-target="#modalConfirmDates">Valider ces dates</button>
    </div>
    <br/>
    <br/>
    <br/>
    <button class="btn btn-outline-danger btn-block" id="boutonSuppDatesPassees" onclick="suppDatesPassees(this);">Supprimer toutes les dates passées</button>
    
</div>
<?php } ?>
    