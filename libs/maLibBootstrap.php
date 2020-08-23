<?php

/**
 * Permet de lire les cookies success,info et error, d'afficher leur contenu si ils existent, puis de les supprimer
 */
function lireInfos(){
	if($succes = valider("success","COOKIE")){
	?>
	<script>
		$(document).ready(function(){
			var contenu = "<?php echo $succes ?>";
			$(".container").prepend(alerteB.clone(1).html(contenu).addClass("alert-success").append(boutonFermerAlerteB));
			Cookies.clear("success");
		})
	</script>
	<?php
	
	}
	if($info = valider("info","COOKIE")){
	?>
	<script>
		$(document).ready(function(){
			var contenu = "<?php echo $info ?>";
			$(".container").prepend(alerteB.clone(1).html(contenu).addClass("alert-warning").append(boutonFermerAlerteB));
			Cookies.clear("info");
		})
	</script>
	<?php
	
	}
	if($erreur = valider("error","COOKIE")){
	?>
	<script>
		$(document).ready(function(){
			var contenu = "<?php echo $erreur ?>";
			$(".container").prepend(alerteB.clone(1).html(contenu).addClass("alert-danger").append(boutonFermerAlerteB));
			Cookies.clear("error");
		})
	</script>
	<?php
	
	}
}



/*
Ce fichier définit diverses fonctions permettant de faciliter la production de mises en formes complexes
Il est utilisé en conjonction avec le style de bootstrap et insère des classes bootstrap
*/

function mkHeadLink($label,$view,$currentView="",$class="",$changementStatut="")
{
	// fabrique un lien pour l'entête en insèrant la classe 'active' si view = currentView

	// EX: <?=mkHeadLink("Accueil","accueil",$view)
	// produit <li class="active"><a href="index.php?view=accueil">Accueil</a></li> si $view= accueil

	if ($view == $currentView) 
		$class .= " active";

	if ($changementStatut == "premium")
		return "<li class=\"$class\"> <a href=\"controleur.php?action=premium\">$label</a></li>";
	else if($changementStatut == "nonpremium")
		return "<li class=\"$class\"> <a href=\"controleur.php?action=non_premium\">$label</a></li>";
	else
		return "<li class=\"$class\"> <a href=\"index.php?view=$view\">$label</a></li>";
}

?>
