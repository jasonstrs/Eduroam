<?php 
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

$nbAccueils=countAccueils();
?>

<link rel="stylesheet" href="css/quill/quill.snow.css"/>
<link rel="stylesheet" href="css/accueil.css"/>

<style>




</style>

	<!-- Modal -->
	<div class="modal fade" id="confirmSupprModal" tabindex="-1" role="dialog" aria-hidden="true">
	<input type="hidden" id="toSuppr" value="0">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			Voulez vous vraiment supprimer cette annonce ?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
			<button type="button" class="btn btn-primary" id="confirmSuppr">Supprimer</button>
		</div>
		</div>
	</div>
	</div>
	<div class="lead" style="text-align:left">
	<div id="mainDiv">
		<div id="gaucheM">
			<input type="hidden" id="nbResults" value="<?php echo $nbAccueils ?>">
			<?php if (valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce"))) { ?>
			<a class="btn bg-warning dropdown-toggle offset-10" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<b>Ajouter</b>
			</a>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				<a class="dropdown-item" href="index.php?view=creerArticle">Annonce</a>
				<a class="dropdown-item" href="index.php?view=creerSondage">Sondage</a>
			</div>
			<?php } ?>
			<div id="pageAccueil">
			</div>
			<p  class="ml-3" style="text-align:left;">
				<a href="#" class="hidden" id="previous">Page précédente</a>
				<span style="float:right;">
				<a href="#" id="next">Page suivante</a>
				</span>
			</p>
		</div>
		<div id="droiteM">
			<h3 class="center mt-4 mb-3" id="titleVideo">Dernière vidéo</h3>
			<div class = "wrapper video center">
				<iframe id="video" class="w100" width="80%" height="100%" src="//www.youtube.com/embed/<?php echo getLastVideos(); ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<div id="divTwitter" class = "wrapper" data-spy="scroll" data-offset="0">
				<a class="twitter-timeline"
				href="https://twitter.com/gregtabibian">
				Tweets by @gregtabibian
				</a>
			</div>
		</div>
	</div>
	</div>

<script src="js/accueil.js"></script>