<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}
if (valider("view","GET")!="accueil" && 
	valider("view","GET")!="login" && 
	valider("view","GET")!="changementPasse" && 
	//Rajouter ici les autres pages accessibles lorsque l'on est deconnecté
	!valider("connecte","SESSION"))
{
	header("Location:./index.php?view=accueil");
	die("");
}

include_once "libs/modele.php";


$VIEW = valider("view","GET");

echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang='fr'>

<!-- **** H E A D **** -->
<head>	

	<link rel="icon" href="ressources/logo.png">
	<script src="ressources/fontawesome/js/all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="bootstrap/js/bootstrap.bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/moment.js"></script>
	<script src="js/Cookies.js"></script>
	<script src="js/header.js"></script>

	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>J'suis pas content TV</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

	<!-- Liaisons aux fichiers css de Bootstrap -->

	<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
	<link href="css/sticky-footer.css" rel="stylesheet" />
	<link href="css/main.css" rel="stylesheet" />
	<link href="css/jquery-ui.css" rel="stylesheet" />
	<link href="ressources/fontawesome/css/all.css" rel="stylesheet" />
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
			z-index:99;
			/* position:fixed;  */
			background-color: #c8912a;
			width : 100%;
		}

		.aligner_images {
			display:flex;
			align-items:center;
		}

		.aligner_images > *{
			margin-right:10px;
		} 

		#iFrame_twitter {
			display:none;
		}

		body {
			height: 100%;
			min-height:100%;
		}


		

	</style>

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
			var delay = false;
        	$("#collapse-navbar").on('click', function (event) { 
				if(delay) return false;
        		collapseIcon();
				delay = true;
				setTimeout(function(){
					delay = false;					
				}, 200);
        	})

			function collapseIcon() {
				if ($('#logo').css("height")=="100px")
        		{
        		    $('#logo').css({
        				height : '50px',
        				transition : "all 0.3s"
					});       			
        		}
        		else{
        			$('#logo').css({
	        			height : '100px',
	        			"transition-delay" : "200ms",
	        			"transition-duration" : "all 0.7s"
					});
        		}
			}
		});
		
		window.twttr = (function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0],
		t = window.twttr || {};
	if (d.getElementById(id)) return t;
	js = d.createElement(s);
	js.id = id;
	js.src = "https://platform.twitter.com/widgets.js";
	
	fjs.parentNode.insertBefore(js, fjs);

	t._e = [];
	t.ready = function(f) {
		t._e.push(f);
	};

	return t;
	}(document, "script", "twitter-wjs"));

    </script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v6.0"></script>


</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>
<script>
	$(window).on('resize', function(){
	  var win = $(this); //this = window
      	if (win.width() >= 996) 
		  $("body").css("font-size","1rem"); 
		else 
			$("body").css("font-size","0.9rem");       
});
</script>

<style>
@media screen and (min-width: 996px) 
{
    body {
		font-size:1rem;
	}
}

@media screen and (max-width: 995px) 
{
    body {
		font-size:0.9rem;
	}
}
</style>


<!-- Wrap all page content here -->
<div style="min-height: calc(100vh - 40px);">
  <!-- Fixed navbar -->

	<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand ml-2 logo" href="index.php?view=accueil"><img id="logo" src="ressources/logo.png" height="100px" width="auto"/></a>


    <button class="navbar-toggler" id="collapse-navbar" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item <?php if ($VIEW=="accueil" || $VIEW=="") {echo "active"; }?>">
          <a class="nav-link" href="index.php?view=accueil"><b>Accueil </b><span class="sr-only">(current)</span></a>
        </li>
		
       	

            <?php if (valider("connecte","SESSION")) { ?>
				<li class="nav-item <?php if ($VIEW=="spectacles") {echo "active"; }?>">
          			<a class="nav-link" href="index.php?view=spectacles"><b>Spectacles</b></a>
        		</li>
        		<li class="nav-item <?php if ($VIEW=="profil") {echo "active"; }?>">
          			<a class="nav-link" href="index.php?view=profil"><b>Profil</b></a>
        		</li>
			<?php } ?>



            <?php if (valider("connecte","SESSION")) { ?>
        		<li class="nav-item <?php if ($VIEW=="video") {echo "active"; }?>">
          			<a class="nav-link" href="index.php?view=video"><b>Vidéos</b></a>
        		</li>
			<?php } ?>

		</ul>


		<ul class="navbar-nav mt-2 mt-lg-0">

			<li class="nav-item aligner_images">
				<div class="fb-like" data-href="https://www.facebook.com/pascontenttv/" data-width="50" data-layout="button_count" 
				data-action="like" data-size="large" data-share="false"></div>

				<a id="iFrame_twitter" class="twitter-follow-button"
				href="https://twitter.com/gregtabibian"
				data-size="large" data-show-count="false">
				Follow @gregtabibian</a>

				<img src="ressources/discord.png" id="btn-Discord" class="pointer" height="40px" width="40px"/>
				<a href="https://fr.tipeee.com/j-suis-pas-content" target="_blank">
					<img src="ressources/tipeee.png" id="btn-Tipeee" class="pointer" height="40px" width="40px" />
				</a>
			</li>
		
			
			<?php if (valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "spectacle")
			|| getDroitByUser(valider("idUser","SESSION"), "utilisateurs") || getDroitByUser(valider("idUser","SESSION"), "video"))) { ?>
				<li class="nav-item <?php if ($VIEW=="admin") {echo "active"; }?>">
          			<a class="nav-link" href="index.php?view=admin"><b>Admin</b></a>
        		</li>
			<?php } ?>


	        	<?php if (!valider("connecte","SESSION")) { ?>
					<li class="nav-item  <?php if ($VIEW=="login") {echo "active"; }?>">
						<a class="nav-link" href="index.php?view=login"><b>Se connecter</b></a>
					</li>		
				<?php } ?>


		        <?php if (valider("connecte","SESSION")) { ?>
					<li class="nav-item">
						<a class="nav-link" href="minControleur/dataConnexion.php?action=logout"><b>Se déconnecter</b></a>
					</li>
				<?php } ?>

			</ul>
  </div>
  

  </nav>
  <!-- Begin page content -->
  <div class="fond">
	<div class="container"> 