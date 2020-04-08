<script src='js/statsSpectacles.js'></script>

<br/>
<label for="selectTri">Trier par :</label>
<select id="selectTri" class="form-control">
  <option value="nbInscrits">Nombre d'inscrits</option>
  <option value="date">Date</option>
  <option value="ville">Ville</option>
  <option value="spectacle">Spectacle</option>
</select>
<br/>

<div id="accordionStats">
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

    <div id="collapseOne" class="collapse statsSpectaclesCollapse" aria-labelledby="headingOne" data-parent="#accordionStats">
      <div class="card-body">
      </div>
    </div>
  </div>
  <div class="card " >
    <div class="card-header pointer" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <h5 class="mb-0 nonSelectionnable">
        <button class="btn btn-link collapsed" >
          Dates validées 
        </button>
        <i>Cliquer pour développer, cliquer sur une date pour accéder au site de vente</i>
        <span class="nbDates" id="nbDatesValidees">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse statsSpectaclesCollapse" aria-labelledby="headingTwo" data-parent="#accordionStats">
      <div class="card-body">
        Cliquer sur une date pour accéder à la vente de billets.
      </div>
    </div>
  </div>
</div>