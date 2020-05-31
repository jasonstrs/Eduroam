<?php 
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}


/**
 * Cette page utilise un fichier de configuration JSON qui se trouve à l'adresse '/ressources/style.json'.
 * 
 */

?>

<script src="js/adminStyle.js"></script>

<!-- PAGE ACCESSIBLE AUX SUPERADMIN UNIQUEMENT -->

<div id="leadAdminStyle" class="lead center">
	<h3 class="gras">Configuration du style</h3>
	<br/>

	<h4>Fond d'écran</h4>
	<div class="btn-group" role="group" aria-label="SelectionBackground" id="groupSelectBack">
		<button type="button" class="btn btn-outline-primary groupSelectBack" value="image" id="backgroundImage">Image</button>
		<button type="button" class="btn btn-outline-primary groupSelectBack" value="color" id="backgroundColor">Couleur</button>
	</div>
	<div id="selectBackValues" style="padding:10px;"></div>
	<hr/>
	<br/>
	<h4>Couleur du header/footer</h4>
	<label for="colorHeadFoot">Couleur du fond</label><br/>
	<input name="colorHeadFoot" class="modif" id="backColorHeadFoot" targetProp="background-color" targetElt=".navbar" type="color"/>
	<br/>
	<label for="colorTxtHeadFoot">Couleur du texte du footer (pour le header, voir 'couleur des liens')</label><br/>
	<input name="colorTxtHeadFoot" class="modif" id="colorHeadFoot" targetProp="color" targetElt=".navbar" type="color"/>
	
	<hr/>
	<br/>
	<h4>Couleur du cadre d'avant-plan</h4>
	<label for="colorLead">Couleur du fond</label><br/>
	<input name="colorLead" class="modif" id="backColorLead" type="color" targetProp="background-color" targetElt=".lead"/>
	<br/>
	<label for="colorTxtLead">Couleur du texte</label><br/>
	<input name="colorTxtLead" class="modif" id="colorLead" targetProp="color" targetElt=".lead" type="color"/>



	<hr/>

	<button class="btn btn-outline-success" id="validerChange">Enregistrer</button>
	<button class="btn btn-outline-danger" id="annulerChange">Annuler</button>

</div>



