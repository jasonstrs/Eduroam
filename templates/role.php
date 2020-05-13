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
<?php } else {
	$roles = getRoles();
	//echo getDroit("utilisateurs");
	?>

	<link rel="stylesheet" href="css/role.css">

	<div id="roleContainer" class="mt-5">
		
		<div>
			<div class="row">
				<div class="col-5 offset-3 list-role">
					Nom du rôle
				</div>
				<div class="col-2 text-right list-role">
				</div>      
			</div>
		</div>

		<?php foreach ($roles as $role) { ?>
		<div class="mt-2" id="role<?php echo $role["idRole"]; ?>">
			<div class="row">
				<div class="col-5 offset-3 list-role">
					<?php echo $role["nom"]; ?>
				</div>
				<div class="col-2 text-right list-role">
					<a class="edit text-decoration-none text-body m-3" href="#collapse<?php echo $role["idRole"]; ?>" idRole="<?php echo $role["idRole"]; ?>">
						<i class="fas fa-pen"></i>
					</a>
					<a href="#" class="remove text-decoration-none text-body" idRole="<?php echo $role["idRole"]; ?>">
						<i class="fas fa-trash-alt" style="color:red;"></i>
					</a>
				</div>      
			</div>
			<div class="collapse" id="collapse<?php echo $role["idRole"]; ?>" roleName="<?php echo $role["nom"]; ?>" 
			video="<?php echo getDroitByRole($role["idRole"], "video"); ?>" spectacle="<?php echo getDroitByRole($role["idRole"], "spectacle"); ?>" 
			user="<?php echo getDroitByRole($role["idRole"], "utilisateurs"); ?>" annonce="<?php echo getDroitByRole($role["idRole"], "annonce"); ?>">
			</div>
		</div>
		<?php } ?>

		<div id="createRole" class="mt-2">
			<div class="row">
				<div class="col-5 offset-3 list-role">
					Créer un nouveau rôle
				</div>
				<div class="col-2 text-right list-role">
					<a class="new text-decoration-none m-3" href="#collapseNew" style="color: black;">
						<i class="fas fa-plus"></i>
					</a>
					<a href="#" class="cancelNew text-decoration-none text-body">
					</a>
				</div>      
			</div>
			<div class="collapse" id="collapseNew">
			</div>
		</div>


		<div id="roleForm" style="display:none;" class="col-7 offset-3 mt-1">
			<div class="input-group flex-nowrap">
				<input type="text" class="form-control" placeholder="Nom du rôle" aria-label="Nome du rôle" autocomplete="no" id="name" name="name">
			</div>
			<div id="nameError" class="text-danger" style="display:none;">Veuillez saisir un nom correct.</div>
			Droits : <br/>
			<div class="row">
				<div class="col-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="video" name="video">
						<label class="form-check-label" for="video">Vidéos</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="spectacle" name="spectacle">
						<label class="form-check-label" for="spectacle">Spectacles</label>
					</div>
					</div>
				<div class="col-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="user" name="user">
						<label class="form-check-label" for="user">Utilisateurs</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="annonce" name="annonce">
						<label class="form-check-label" for="annonce">Annonces</label>
					</div>
				</div>
			</div>
		</div>

	</div>


	<!-- <script>
		$(function(){
			$.ajax({
				type: "POST",
				url: "./minControleur/testRole.php",
				data: {"nom":"test", "droits":{"video":1, "spectacle":0, "utilisateurs":0, "annonce":0,}},
				success: function(oRep){
					console.log("Fini.");
					console.log(oRep);
				},
				dataType: "text"
			});
		})
	</script> -->

	<script src='js/role.js'></script>
<?php } ?>