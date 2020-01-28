<?php


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
