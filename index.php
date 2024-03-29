<?php
session_start();
/*test*/
/*
Cette page génère les différentes vues de l'application en utilisant des templates situés dans le répertoire "templates". Un template ou 'gabarit' est un fichier php qui génère une partie de la structure XHTML d'une page. 

La vue à afficher dans la page index est définie par le paramètre "view" qui doit être placé dans la chaîne de requête. En fonction de la valeur de ce paramètre, on doit vérifier que l'on a suffisamment de données pour inclure le template nécessaire, puis on appelle le template à l'aide de la fonction include

Les formulaires de toutes les vues générées enverront leurs données vers la page data.php pour traitement. La page data.php redirigera alors vers la page index pour réafficher la vue pertinente, généralement la vue dans laquelle se trouvait le formulaire. 
*/


	include_once "libs/maLibUtils.php";
	include_once "libs/maLibBootstrap.php";
	include_once "libs/maLibForms.php";

	echo "	<head>
				<link rel='stylesheet' media='screen' type='text/css' href='css/style.css'/>
				"./*"<script type='text/javascript'>
					console.log = function(){};
					function handleErrors(){return true;}
					window.onerror=handleErrors;
					window.onwarning=handleErrors;
					
				</script>".*/"
			</head>";
	//ok
	// on récupère le paramètre view éventuel 
	$view = valider("view"); 
	/* valider automatise le code suivant :
	if (isset($_GET["view"]) && $_GET["view"]!="")
	{
		$view = $_GET["view"]
	}*/

	// S'il est vide, on charge la vue accueil par défaut
	if (!$view) $view = "accueil"; 

	// NB : il faut que view soit défini avant d'appeler l'entête

	// Dans tous les cas, on affiche l'entete, 
	// qui contient les balises de structure de la page, le logo, etc. 
	// Le formulaire de recherche ainsi que le lien de connexion 
	// si l'utilisateur n'est pas connecté 

	include("templates/header.php");

	// En fonction de la vue à afficher, on appelle tel ou tel template
	switch($view)
	{		

		case "accueil" : 
			include("templates/accueil.php");
		break;


		default : // si le template correspondant à l'argument existe, on l'affiche
			if (file_exists("templates/$view.php"))
				include("templates/$view.php");
			else{
				include("templates/accueil.php");
				?>
					<script>
						history.pushState('','','index.php?view=accueil');
					</script>
				<?php
			}
		break;

	}


	// Dans tous les cas, on affiche le pied de page
	// Qui contient les coordonnées de la personne si elle est connectée
	include("templates/footer.php");


	
?>

<?php

/**
 * chargement du style
 */

if(file_exists("ressources/style.json")){
	
	//Si on a un fichier de configuration existant, on le charge.

	$json = file_get_contents("ressources/style.json");
	$tab = json_decode($json,TRUE);

	//die(tprint($tab));
	
foreach($tab["content"] as $val){
	?>
	<script>
		
		var elt = "<?php echo $val["targetElt"] ?>";
		var prop = "<?php echo $val["targetProp"] ?>";
		var val = "<?php echo $val["value"] ?>";
		var id = "#<?php echo $val["id"] ?>";
		$(elt).css(prop,val);
		
	</script>


	<?php
}

if(isset($tab["background-type"])){
	$type = $tab["background-type"];
	if($type == "image"){
		?>
			<script>$(".fond").css("background-image","url(ressources/backImg/backImage)")</script>
		<?php
	}
}

}


?>







