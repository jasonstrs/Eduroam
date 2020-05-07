<?php
    // Si la page est appelée directement par son adresse, on redirige en passant par la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }
?>

<script src='js/spectaclesUsers.js'></script>
<link rel="stylesheet" type="text/css" href="./css/spectacle.css"/>
<br/>
<?php
  lireInfos();
?>
<div id="descriptionSpectacles">
  Vous pouvez vous déclarer <i>intéressé</i> pour des dates en attente.<br/>
  Si une date en attente intéresse assez de personnes, elle pourra passer de <i>en attente</i> à <i>validée</i>.<br/>
  Vous pourrez alors accéder au site de vente de billets concernant cette date.<br/>

</div>
<br/>
<label for="selectTri">Trier par :</label>
<select id="selectTri" class="form-control">
  <option value="nbInscrits">Nombre d'inscrits</option>
  <option value="date">Date</option>
  <option value="ville">Ville</option>
  <option value="spectacle">Spectacle</option>
</select>
<br/>

Rechercher les spectacles dans votre ville : <br>
<input id="txtRechercheVilleUser" type="text" class="form-control mb-2 mr-sm-3" placeholder="Entrez votre ville"/>
<div id="btnRechercheVilleUser" class="btn btn-outline-primary mb-2 pointer" >Rechercher</div>
<div id="accordionUser">

  <div class="card " >
    <div class="card-header pointer" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
      <h5 class="mb-0 nonSelectionnable">
        <button class="btn btn-link">
          Dates en attente 
        </button>
        <i>Cliquer pour développer</i>
        <span class="nbDates" id="nbDatesEnAttente">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>

    <div id="collapseOne" class="collapse userSpectaclesCollapse" aria-labelledby="headingOne" data-parent="#accordionUser">
      <div class="card-body">
      </div>
    </div>
  </div>

  <div class="card " >
    <div class="card-header pointer" id="headingThree" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <h5 class="mb-0 nonSelectionnable">
        <button class="btn btn-link collapsed" >
          Dates validées 
        </button>
        <i>Cliquer pour développer, cliquer sur une date pour accéder au site de vente</i>
        <span class="nbDates" id="nbDatesValidees">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse userSpectaclesCollapse" aria-labelledby="headingTwo" data-parent="#accordionUser">
      <div class="card-body">
      </div>
    </div>
  </div>

  <div class="card " >
    <div class="card-header pointer" id="headingFour" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
      <h5 class="mb-0 nonSelectionnable">
        <button class="btn btn-link">
          Vos dates en attente 
        </button>
        <i>Cliquer pour développer</i>
        <span class="nbDates" id="nbVosDatesEnAttente">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>

    <div id="collapseThree" class="collapse userSpectaclesCollapse" aria-labelledby="headingThree" data-parent="#accordionUser">
      <div class="card-body">
      </div>
    </div>
  </div>

  <div class="card " >
    <div class="card-header pointer" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
      <h5 class="mb-0 nonSelectionnable">
        <button class="btn btn-link">
          Vos dates validées 
        </button>
        <i>Cliquer pour développer, cliquer sur une date pour accéder au site de vente</i>
        <span class="nbDates" id="nbVosDatesValidees">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>

    <div id="collapseFour" class="collapse userSpectaclesCollapse" aria-labelledby="headingFour" data-parent="#accordionUser">
      <div class="card-body">
      </div>
    </div>
  </div>
</div>


<?php
$idUser = valider("idUser","SESSION");
?>
<script>
  sessionStorage.setItem("idU",<?php echo $idUser?>);
</script>



<div id="infosDatesSelectionnees">abc</div>