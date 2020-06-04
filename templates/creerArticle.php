<?php
    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }
    if(valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce"))) {
?>
  
<link rel="stylesheet" href="css/quill/second.css" />
<link rel="stylesheet" href="css/quill/first.css" />
<link rel="stylesheet" href="css/quill/quill.snow.css" />

<style>
  body > #standalone-container {
    margin: 50px auto;
    max-width: 720px;
  }
  #editor-container {
    height: 350px;
  }
</style>

<div class="page-header">
	<h1>Créer une annonce</h1>
</div>
  
<div id="standalone-container" style="background-color:rgb(245,245,245)">
  <div id="toolbar-container">
    <span class="ql-formats">
      <select class="ql-font"></select>
      <select class="ql-size"></select>
    </span>
    <span class="ql-formats">
      <button class="ql-bold"></button>
      <button class="ql-italic"></button>
      <button class="ql-underline"></button>
      <button class="ql-strike"></button>
    </span>
    <span class="ql-formats">
      <select class="ql-color"></select>
      <select class="ql-background"></select>
    </span>
    
  </div>
  <div id="editor-container"></div>
</div>

<button id="submit" type="button" class="btn btn-outline-secondary mt-3 offset-10">Créer l'annonce</button>
  
<script src="js/quill/trois.js"></script>
<script src="js/quill/quatre.js"></script>
<script src="js/quill/quill.min.js"></script>

<script>
	var quill = new Quill('#editor-container', {
		modules: {
			formula: true,
			syntax: true,
			toolbar: '#toolbar-container'
		},
		placeholder: 'Saisir votre texte',
		theme: 'snow'
	});

	$("#submit").click(function(){
		$.ajax({
			type: "POST",
			url: "./minControleur/dataAccueil.php",
			data: {"action":"addAnnonce", "contenu":$(".ql-editor").html()},
			success: function(oRep){
				console.log(oRep);
				document.location.href="index.php?view=accueil";
			},
			dataType: "text"
		});
	})

</script>

<?php } else echo "Vous n'avez pas accès à cette page"; ?>