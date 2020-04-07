<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
} 
if(valider("view","GET")=="role") {
?>
Vous n'avez pas accés à cette page
<?php } else { ?>

	<link rel="stylesheet" href="css/users.css">

	<div class="mt-2">
		<p>Nombre d'utilisateurs inscrits : <?php echo countUsers();?></p>
	</div>
	<div class="row">
		<input type="text" size="8" class="form-control offset-3 col-6" placeholder="Chercher un utilisateur" aria-label="Chercher un utilisateur" autocomplete="no" id="userSearch" name="userSearch">
		<div id="userResult" class="offset-3 col-6">
		</div>
	</div>
	<script src='js/users.js'></script>
<?php } ?>