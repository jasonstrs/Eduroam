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
	<div id="containerUser"></div>
	<div class="mt-2">
		<p>Nombre d'utilisateurs inscrits : <?php echo countUsers();?></p>
	</div>
	<div class="row">
		<input type="text" class="form-control offset-3 col-6" placeholder="Chercher un utilisateur" aria-label="Chercher un utilisateur" autocomplete="no" id="userSearch" name="userSearch">
		<div id="userResult" class="offset-3 col-6">
		<p class="hidden"></p>
		</div>
	</div>
	<hr>
	<div id="dispUser" class="hidden">
		<input id="idUserInput" type="hidden" value="0"/>
		<div class="form-group row">
			<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="inputEmail">
			</div>
			<div id="verifMail" class='offset-sm-2 text-danger'></div>
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
			<input id="changepass" type="hidden" value="0"/>
			<div class="form-group row" id="pass">
				<label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
				<div class="col-sm-10 divForm">
					<input type="password" class="form-control" id="inputPassword">
				</div>
				<div id="verifPasse" class=' offset-sm-2 text-danger'></div>
			</div>
			<div class="form-group row" id="pass">
				<span class="offset-sm-2 font-weight-light text-info pointer changepass">Ne pas changer le mot de passe</span>
			</div>
		</div>
		<?php if(valider("admin","SESSION")==1) { ?>
		<div class="offset-sm-2 custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="switchAdmin">
			<label class="custom-control-label" for="switchAdmin">Administrateur</label>
		</div>
		<?php } ?> <br/>
		<div class="offset-sm-2">
			Attribuer des rôles :
			<input id="upToDate" type="hidden" value="0"/>
			<div id="addRole" class="row">
				<div class="col-sm-5" id="roleLeft">
				</div>
				<div class="col-sm-5" id="roleRight">
				</div>
			</div>
		</div><br/>
		<div class="row">
			<button id="saveUser" type="button" class="btn btn-outline-secondary offset-sm-2">Sauvegarder</button>
			<button id="banUser" type="button" class="btn btn-outline-secondary  offset-sm-1">Bannir</button>
			<button id="unbanUser" type="button" class="btn btn-outline-secondary  offset-sm-1">Débannir</button>
		</div>
	</div>
	<script src='js/users.js'></script>
<?php } ?>