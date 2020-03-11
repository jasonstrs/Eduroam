<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 
		

?>



	
	<div class="lead">

	<form action="sondage.php" method="POST" class="menu p-4 row" id="creerSondage" enctype="multipart/form-data">

		<div class="col-8">


			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">Titre du sondage</span>
			  </div>
			  <input type="text" class="form-control" name="titre" aria-describedby="basic-addon1">
			</div>

			
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">Question</span>
			  </div>
			  <input type="text" class="form-control" name="question" aria-describedby="basic-addon1">
			</div>
			
			<div class="propositions"> </div>

			<input type="button" id="addrep" class="btn btn-primary btn-lg" value="Ajouter une Réponse"/>
			<button class="btn btn-primary btn-lg redo">Ajouter une réponse ouverte</button>

			</div>
			
			<div class="col-3 offset-1 border-left">
			
			<input type="submit" class="btn btn-primary btn-lg" name="action" value="Créer le sondage"/>
			</div>


		
		
	</form>
	
	<div id="success" style="display: none;">
		<p style='color: green;'>Le sondage a bien été créé</p>
		<button class="btn btn-primary btn-lg redo">Créer un autre sondage</button>
	</div>

	<div id="error" style="display: none;">
		<p id="p-error" style='color: red;'></p>
		<button class="btn btn-primary btn-lg redo">Réessayer</button>
	</div>
	
	</div>



	<script>

		reponseid = 1


		$(function(){
		 	$("#addrep").click(function(){
		 		console.log("test");
                var reponse = $("<div class='input-group mb-3'>")
                .append("<div class='input-group-prepend'><span class='input-group-text' id='basic-addon1'>Réponse "+reponseid+"</span></div>")
                .append("<input type='text' class='form-control' name='question' aria-describedby='basic-addon1'>")
                .append("</div");
                $(".propositions").append(reponse.clone(true).attr("name", "reponse[]").attr("id", "reponse"+reponseid));
                reponseid++;
                window.scrollTo(0, 500000000);
            });
		})





	</script>


