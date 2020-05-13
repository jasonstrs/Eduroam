<?php
    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }
    if(valider("connecte","SESSION") && (valider("admin","SESSION")==1 || getDroitByUser(valider("idUser","SESSION"), "annonce"))) {
?>


    <h3>
        <div id="titre">
            Création d'un sondage
        </div>
    </h3>

    <br/>

    <button id="addReponse" class="btn btn-outline-secondary">Ajouter une réponse possible</button>    


    <form action="dataSondage.php" method="POST" class="menu p-4 row" id="creerSondage" enctype="multipart/form-data">

            <div class="col-8">

                
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Question</span>
                  </div>
                  <input type="input-group-text" class="form-control" id="intitule">
                </div>

                <div id="box_fullpage">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="reponse input-group-text">Reponse 1</span>
                      </div>
                      <input type="input-group-text" class="form-control" id="reponse1">
                    </div>

                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="reponse input-group-text">Reponse 2</span>
                      </div>
                      <input type="input-group-text" class="form-control" id="reponse2">
                    </div>

                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="hideResult">
                  <label class="form-check-label" for="hideResult">
                    Masquer les résultats à l'utilisateur
                  </label>
                </div>
				<div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="dateEndCheck">
                  <label class="form-check-label" for="dateEndCheck">
                    Fermer le sondage après :
                  </label>
				</div>
				<div class="date">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="reponse input-group-text">Date de fin</span>
                      </div>
                      <input type="date" class="form-control" id="dateEnd">
                    </div>
                </div>
            
            </div>
                
			<button id="submit" type="button" class="btn btn-outline-secondary mt-3 offset-10">Créer le sondage</button>
            <!-- <input  id="soumettre" type="submit" class="btn btn-warning btn-lg redo" name="action" value="Soumettre le sondage"/> -->

    </form>



    <div id="success" style="display: none;">
        <p style='color: green;'>Le sondage a bien été ajouté</p>
        <button class="btn btn-primary btn-lg redo">Ajouter un autre Sondage</button>
    </div>

    <div id="error" style="display: none;">
        <p id="p-error" style='color: red;'></p>
        <button class="btn btn-primary btn-lg redo">Réessayer</button>
    </div>


        
    </div>

<script>
	var reponse = 2

	$("#addReponse").click(function(){
		add_block();
	});

	function add_block(){
		reponse = reponse + 1
		var d = $('#box_fullpage');
		d.append("<div class=\"input-group mb-3\"><div class=\"input-group-prepend\"><span class=\"reponse input-group-text\">Reponse "+reponse+"</span></div><input type=\"input-group-text\" class=\"form-control\" id=\"reponse"+reponse+"\"></div>");
	}

	$("#submit").click(function() {
		var reponses = [];
		for(let i=1; i<reponse+1; i++) {
			if(/([^\s])/.test($("#reponse"+i).val())) reponses.push($("#reponse"+i).val()) //console.log(i);
		}
		//console.log(reponses);
		let dateEnd = $("#dateEndCheck").prop("checked") ? $("#dateEnd").val() : 0;
		let hideResult = $("#hideResult").prop("checked") ? 1 : 0;
		$.ajax({
			type: "POST",
			url: "./minControleur/dataAccueil.php",
			data: {"action":"addSondage", "intitule":$("#intitule").val(), "reponses":reponses, "hideResult":hideResult, "dateEnd":dateEnd},
			success: function(oRep){
				console.log(oRep);
				document.location.href="http://localhost/eduroam/index.php?view=accueil";
			},
			dataType: "text"
		});
	})
</script>



<?php } else echo "Vous n'avez pas accès à cette page"; ?>
    
