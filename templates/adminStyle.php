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
if(file_exists("../ressources/style.json")){
	
	//Si on a un fichier de configuration existant, on le charge.
	
	$json = file_get_contents("../ressources/style.json");
	$tab = json_decode($json,TRUE);
}
else{

	//Sinon, on en crée un avec les valeurs par défaut.

}

?>

<!-- PAGE ACCESSIBLE AUX SUPERADMIN UNIQUEMENT -->

<div class="lead center">
	<h3 class="gras">Configuration du style</h3>
	<br/>

	<h4>Fond d'écran</h4>
	<div class="btn-group" role="group" aria-label="SelectionBackground" id="groupSelectDates">
		<button type="button" class="btn btn-outline-primary" value="image">Image</button>
		<button type="button" class="btn btn-outline-primary" value="color">Couleur</button>
	</div>
	<hr/>
	<br/>
	<h4>Couleur du header/footer</h4>
	<input name="colorHeadFoot" id="colorHeadFoot" type="color"/>
	<br/><label for="colorHeadFoot">Cliquez pour sélectionner une couleur</label>
	<hr/>
	<br/>
	<h4>Couleur du cadre d'avant-plan</h4>
	<input name="colorLead" id="colorLead" type="color"/>
	<br/><label for="colorLead">Cliquez pour sélectionner une couleur</label>

</div>