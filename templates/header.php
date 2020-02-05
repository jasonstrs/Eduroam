<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
include_once "libs/modele.php";
// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function() {
        	$("#collapse-navbar").click(function(){
        		$('#logo').css({
        			height="50px";
				});

        	})
        });

    </script>
	<link rel="icon" href="ressources/logo.png">
	<!--<script src="https://kit.fontawesome.com/05f96bf93f.js"></script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
	
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bibliio</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

	<!-- Liaisons aux fichiers css de Bootstrap -->

	<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
	<link href="css/sticky-footer.css" rel="stylesheet" />
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->

	<style>
		.orange:hover {
			background-color: #cb9c35;
		}
		.logo {
			width:100px;
			height: 45px;
		}
		.navbar {
			position:fixed; 
			background-color: #c8912a;
			width : 100%;
		}


		

	</style>

	

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<!-- style inspiré de http://www.bootstrapzero.com/bootstrap-template/sticky-footer --> 

<!-- Wrap all page content here -->
<div id="wrap">
  <!-- Fixed navbar -->

	<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand ml-2 logo" href="index.php?view=accueil"><img id="logo" src="ressources/logo.png" height="100px" width="auto"/></a>


    <button class="navbar-toggler" id="collapse-navbar" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="index.php?view=accueil"><b>Accueil </b><span class="sr-only">(current)</span></a>
        </li>
		
       	<?php if (valider("connecte","SESSION")) { ?>
		<div class="dropdown navbar-nav">
		  <a class="nav-link dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<b>Spectacle</b>
		  </a>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="background-color: #c8912a">
			<a class="dropdown-item orange" href="index.php?view=preinscription"><b>Préinscription</b></a>
			<a class="dropdown-item orange" href="index.php?view=inscription"><b>Inscription</b></a>
		  </div>
		</div>
		<?php } ?>
		


            <?php if (valider("connecte","SESSION")) { ?>
        		<li class="nav-item">
          			<a class="nav-link" href="index.php?view=profil"><b>Profil</b></a>
        		</li>
			<?php } ?>



            <?php if (valider("connecte","SESSION")) { ?>
        		<li class="nav-item">
          			<a class="nav-link" href="index.php?view=video"><b>Vidéo</b></a>
        		</li>
			<?php } ?>

		</ul>


		<ul class="navbar-nav mt-2 mt-lg-0">

			<li class="nav-item">
				<img src="ressources/discord.png" height="40px" width="40px"/>

				<img src="ressources/tipeee.png" height="40px" width="40px" />
			</li>
		
			
			<?php if (valider("connecte","SESSION") && valider("admin","SESSION")==1) { ?>
				<div class="dropdown navbar-nav">
				  <a class="nav-link dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<b>Administration</b>
				  </a>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="background-color: #c8912a">
				  	<a class="dropdown-item orange" href="index.php?view=gererrole"><b>Gérer les rôles</b></a>
					<a class="dropdown-item orange" href="index.php?view=creerrole"><b>Créer un nouveau rôle</b></a>
					<a class="dropdown-item orange" href="index.php?view=gereruser"><b>Gérer les utilisateurs</b></a>
				  </div>
				</div>
			<?php } ?>


	        	<?php if (!valider("connecte","SESSION")) { ?>
					<li class="nav-item">
						<a class="nav-link" href="index.php?view=login"><b>Se connecter</b></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?view=inscription"><b>S'inscrire</b></a>
					</li>
				<?php } ?>


		        <?php if (valider("connecte","SESSION")) { ?>
					<li class="nav-item">
						<a class="nav-link" href="index.php?view=logout"><b>Se déconnecter</b></a>
					</li>
				<?php } ?>

			</ul>


  </div>
  

  </nav>
  <!-- Begin page content -->
</div>
<div class="container">