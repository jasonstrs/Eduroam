<?php

	// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
	if (basename($_SERVER["PHP_SELF"]) != "index.php")
	{
		header("Location:../index.php");
		die("");
	}

?>


</div>
<!-- fin du content --> 

<!-- fin du wrap (dans le header) -->
</div>

<<<<<<< Updated upstream
<div id="footer">
  <div class="container">
   	 <p class="text-muted credit">
		<?php
		// Si l'utilisateur est connecte, on affiche un lien de deconnexion 
		if (valider("connecte","SESSION"))
		{
			echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; "; 
			echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
		}
		?>
	</p>
  </div>
</div>
=======


<nav id="footer" class="navbar fixed-bottom navbar-expand-lg navbar-light" style="background-color : #c8912a">

      	<ul class="navbar-nav mx-auto mt-2 mt-lg-0">
      		<li class="nav-item">
		        <span class="navbar-text  mx-5">adresse email à modifier</span>
		    </li>
	        <li class="nav-item">
				<img class="mx-2" src="ressources/tipeee.png" height="30px" width="auto"/>
				<img class="mx-2" src="ressources/twitter.png" height="30px" width="auto"/>
				<img class="mx-2" src="ressources/facebook.png" height="30px" width="auto"/>
				<img class="mx-2" src="ressources/discord.png" height="30px" width="auto"/>
			</li>
		</ul>

</nav>

>>>>>>> Stashed changes

</body>

<footer>
<script src="js/bibliio.js"></script>
</footer>

</html>
