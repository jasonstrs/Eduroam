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

<style>
	#containFooter {
		display: flex;
		width: 100%;
		justify-content: space-between;
		flex-wrap: wrap;
	}

	p {
		margin: 0;
		padding: 0.5rem;
	}

	#foot a{
		color:black;
	}

	#foot a:hover {
		cursor:pointer;
		font-weight: bold;
		text-decoration:none;
	} 

	footer {
    clear: both;
    position: relative;
    height: 40px;
}
	
</style>



<nav id="foot" class="navbar navbar-expand-lg navbar-light navBars" style="background-color : #c8912a;padding:0;" >
		<div id="containFooter">
			<p>© Grégory Tabibian 2020 | <a href="index.php?view=mentionsLegales">Mentions légales</a>
			<?php if (valider("connecte","SESSION")) {
					$MAIL = valider("email","SESSION");
					echo "<p><i>".$MAIL."</i></p>";
			} ?>
		</div>
</nav>


</body>

</html>

