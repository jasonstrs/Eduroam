<?php
    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }
    include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./style/spectacle.css"/>
<script src='./js/spectacle.js'></script>
<h3>
    <div id="titre">
        Planification des spectacles - Ajouter une ville
    </div>
</h3>

<div class="lead">
    <div id="entrerVille">
        <span class="gras">Entrer une ville où créer un Spectacle : </span><br>
        <?php 
            mkInput("text","nomVille","","placeholder='Entrer le nom de la ville' class='form-control' id='champTxtVille'");
        ?>
        <button id="validerEntreeVille" class="btn btn-primary" style="margin-bottom:3px;">Valider</button>
    </div>
    <div id="listeVilles">
        <br><span class="gras">Villes où des spectacles ont déja été proposés : </span>
        Cliquez pour modifier/ajouter des dates, ou consulter les détails pour cette ville
        <br>
    
        <script>
            chargerVilles();
        </script>
        
    </div>
    <div id="choisirDates">
        <br><span class="gras"></span>
    </div>
    
</div>

    
