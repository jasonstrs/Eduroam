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

<script>window.twttr = (function(d, s, id) {
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
}(document, "script", "twitter-wjs"));</script>



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


</body>

</html>

