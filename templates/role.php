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
	//echo getDroit("video");
	$roles = getRoles();
	?>

	<link rel="stylesheet" href="css/role.css">

	<div class="mt-5">
		
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
		<div class="mt-2">
			<div class="row">
				<div class="col-5 offset-3 list-role">
					<?php echo $role["nom"]; ?>
				</div>
				<div class="col-2 text-right list-role">
					<a href="#" class="text-decoration-none text-body">
						<svg class="bi bi-pencil" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M13.293 3.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM14 4l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
							<path fill-rule="evenodd" d="M14.146 8.354l-2.5-2.5.708-.708 2.5 2.5-.708.708zM5 12v.5a.5.5 0 00.5.5H6v.5a.5.5 0 00.5.5H7v.5a.5.5 0 00.5.5H8v-1.5a.5.5 0 00-.5-.5H7v-.5a.5.5 0 00-.5-.5H5z" clip-rule="evenodd"/>
						</svg>
					</a>
					<a href="#" class="text-decoration-none text-body">
						<svg class="bi bi-trash" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M7.5 7.5A.5.5 0 018 8v6a.5.5 0 01-1 0V8a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V8a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V8z"/>
							<path fill-rule="evenodd" d="M16.5 5a1 1 0 01-1 1H15v9a2 2 0 01-2 2H7a2 2 0 01-2-2V6h-.5a1 1 0 01-1-1V4a1 1 0 011-1H8a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM6.118 6L6 6.059V15a1 1 0 001 1h6a1 1 0 001-1V6.059L13.882 6H6.118zM4.5 5V4h11v1h-11z" clip-rule="evenodd"/>
						</svg>
					</a>
				</div>      
			</div>
		</div>
	
		<?php } ?>

	</div>


	<!-- <script>
		$(function(){
			$.ajax({
				type: "POST",
				url: "./minControleur/testRole.php",
				data: {"nom":"test", "droits":{"video":1, "spectacle":1, "utilisateurs":1, "annonce":1,}},
				success: function(oRep){
					console.log("Fini.");
					console.log(oRep);
				},
				dataType: "text"
			});
		})
	</script> -->


<?php } ?>