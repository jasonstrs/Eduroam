<?php
    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }
?>
<link rel="stylesheet" type="text/css" href="./css/spectacle.css"/>
<script src='./js/spectacle.js'></script>
<h3>
    <div id="titre">
        Planification des spectacles
    </div>
</h3>

<div class="lead">
    <div id="entrerVille">
        <span class="gras">Entrer une ville où créer un Spectacle : </span><br>
        <?php 
            mkInput("text","nomVille","","placeholder='Entrer le nom de la ville' class='form-control' id='champTxtVille'");
        ?>
        <button id="validerEntreeVille" class="btn btn-primary" style="margin-bottom:3px;">Valider</button>
        <img class="loader" src="./ressources/loading.gif" style="width:50px;display:none;"/>
    </div>
    <div id="listeVilles">
        <span class="gras">Villes où des spectacles ont déja été proposés : </span>
            Cliquez sur les villes pour afficher toutes les dates.
        <br>
    
        <script>
            chargerVilles();
        </script>
        
    </div>
    <div id="choisirDates">
        <br><span class="gras"></span>
    </div>
    
</div>

    
