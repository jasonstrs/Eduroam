<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

$video = valider("id", "GET");

?>
	<link rel="stylesheet" href="css/video.css">
	<br/><br/>
	<input type="hidden" id="videoId" value="<?php echo $video ?>">
	<div class="lead">
		<div class="row">
			<div class="col-md-7">
				<iframe id="video" class="video w100" width="100%" height="360" src="//www.youtube.com/embed/<?php echo $video ?>" frameborder="0" allowfullscreen></iframe>
				<p id="title"></p>
			</div>
			<div class="col-md-5">
				<div class="input-group mb-3">
					<input id="search" type="text" class="form-control" placeholder="Rechercher" aria-label="Rechercher" aria-describedby="search">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" id="search-button">
							<img src="./ressources/icons/search.svg" alt="" title="search">
						</button>
					</div>
				</div>
				<div id="results">
				</div>
			</div>
		</div>
	</div>
	<script src="js/watchvideo.js"></script>
	<script src="https://apis.google.com/js/client.js?onload=init"></script>