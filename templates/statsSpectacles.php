<script src='js/statsSpectacles.js'></script>

<div id="accordion">
  <div class="card pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link">
          Dates en attente
        </button>
        <span class="nbDates" id="nbDatesEnAttente">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Ici, on affiche les dates en attente.
      </div>
    </div>
  </div>
  <div class="card pointer" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" >
          Dates validées
        </button>
        <span class="nbDates" id="nbDatesValidees">Chargement <img src="./ressources/loading.gif" /></span>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
          Ici, les dates validées et en cours de vente
      </div>
    </div>
  </div>
</div>