<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
} 
if(valider("view","GET")=="users") {
?>
Vous n'avez pas accés à cette page
<?php } else { 
    $series = getSeries(); ?>

	<link rel="stylesheet" href="css/videoAdmin.css">
    <div class="mt-2"></div>
        <div class="row">
            <div class="col-md-6 offset-md-5">
                <button id="actualiser" type="button" class="btn btn-light">Actualiser</button> </br>
            </div>
            <div class="mt-3 mb-3 offset-md-2 col-md-8">
                <div id="series">
                    <div id="chooseSeries">
                        Sélectionner une série :
                        <select id="selectSerie" class="form-control">
                            <?php foreach ($series as $serie) { ?>
                            <option value="<?php echo $serie['id_serie']?>"><?php echo $serie['nom']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <span id="noSerie">Il n'y a actuellement aucune série</span>
                    <div class="row mt-3">
                        <button id="newSerie" type="button" class="btn btn-outline-secondary ml-3">Créer une nouvelle série</button>
                        <button id="deleteSerie" type="button" class="btn btn-outline-secondary offset-sm-1">Supprimer la série</button>
                    </div>
                </div>  
            </div>
            <div id="createSerie" class="hidden offset-3 col-6">
                <input type="text" class="form-control " placeholder="Nom de la série" aria-label="Nom de la série" autocomplete="no" id="nomSerie" name="nomSerie">
                <div class="row mt-3">
                    <button id="creerSerie" type="button" class="btn btn-outline-secondary ml-3">Créer la série</button>
                    <button id="cancelSerie" type="button" class="btn btn-outline-secondary offset-sm-1">Annuler</button>
                </div>
            </div>
        </div>
    </div>


	<script src='js/videoAdmin.js'></script>
    <script src="https://apis.google.com/js/client.js?onload=init"></script>
<?php } ?>