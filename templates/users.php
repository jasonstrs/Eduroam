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
<?php } else { ?>

	<link rel="stylesheet" href="css/users.css">

	<div class="mt-2">
		<p>Nombre d'utilisateurs inscrits : <?php echo countUsers();?></p>
	</div>
	<div class="row">
		<input type="text" class="form-control offset-3 col-6" placeholder="Chercher un utilisateur" aria-label="Chercher un utilisateur" autocomplete="no" id="userSearch" name="userSearch">
		<div id="userResult" class="offset-3 col-6">
		</div>
	</div>
	<hr>
	<div id="dispUser" class="">
		<div class="form-group row">
				<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="inputEmail">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputFirstName" class="col-sm-2 col-form-label">Prénom</label>
				<div class="col-sm-10 divForm" id="firstName">
					<input type="text" class="form-control" id="inputFirstName">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputName" class="col-sm-2 col-form-label">Nom</label>
				<div class="col-sm-10 divForm" id="name">
					<input type="text" class="form-control" id="inputName">
				</div>
			</div>
			<div class="form-group row" id="pass">
				<span class="offset-sm-2 font-weight-light text-info pointer changepass">Changer le mot de passe</span>
			</div>
			<div id="changePassDiv" class="hidden">
				<div class="form-group row" id="pass">
					<label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
					<div class="col-sm-10 divForm">
						<input type="password" class="form-control" id="inputPassword">
					</div>
				</div>
				<div class="form-group row" id="passConfirm">
					<label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirmer le mot de passe</label>
					<div class="col-sm-10 divForm">
						<input type="password" class="form-control" id="inputConfirmPassword">
					</div>
				</div>
				<div class="form-group row" id="pass">
					<span class="offset-sm-2 font-weight-light text-info pointer validepass">Valider le mot de passe</span>
				</div>
			</div>
		</div>
	</div>
	<script src='js/users.js'></script>
<?php } ?>