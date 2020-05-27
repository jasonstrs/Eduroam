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

	$tab=array();
	$tab["leadColor"] = "#F5F5F5";
	$tab["navColor"] = "#c8912a";
	$tab["background"]["type"] = "color";
	$tab["background"]["color"] = "#FFFFFF";


	$json = json_encode($tab);

	$myfile = fopen("ressources/style.json", "w") or die("Unable to open file!");

	fwrite($myfile, $json);

	fclose($myfile);
}

//On a maintenant un tableau avec soit les valeurs du fichier, soit les valeurs par défaut.
$leadColor = $tab["leadColor"];
$navColor = $tab["navColor"];

$backImage = "active";
$backColor = "";

if($tab["background"]["type"] == "color"){
	$backImage = "";
	$backColor = "active";
}

?>

<!-- PAGE ACCESSIBLE AUX SUPERADMIN UNIQUEMENT -->

<div class="lead center">
	<h3 class="gras">Configuration du style</h3>
	<br/>

	<h4>Fond d'écran</h4>
	<div class="btn-group" role="group" aria-label="SelectionBackground" id="groupSelectDates">
		<button type="button" class="btn btn-outline-primary <?php echo $backImage ?>" value="image">Image</button>
		<button type="button" class="btn btn-outline-primary <?php echo $backColor ?>" value="color">Couleur</button>
	</div>
	<hr/>
	<br/>
	<h4>Couleur du header/footer</h4>
	<input name="colorHeadFoot" id="colorHeadFoot" type="color" value="<?php echo $navColor ?>"/>
	<br/><label for="colorHeadFoot">Cliquez pour sélectionner une couleur</label>
	<hr/>
	<br/>
	<h4>Couleur du cadre d'avant-plan</h4>
	<input name="colorLead" id="colorLead" type="color" value="<?php echo $leadColor ?>"/>
	<br/><label for="colorLead">Cliquez pour sélectionner une couleur</label>

</div>

