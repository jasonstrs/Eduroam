$(function() {
	resetVideoHeight();
	$(window).on("resize", resetVideoHeight);
	var page=0;
	var nbResults = $("#nbResults").val();

	if(nbResults<5) $("#next").hide();

	search();

	function search() {
		$("#pageAccueil").load("./templates/pageAccueil.php", {
			page : page,
		},
		()=>{ // on lance cette fonction quand le load est complété !
			checkVideo();
		});
		
	}

	$("#next").click(function(){
		page++;
		$("#previous").show();
		if(page==Math.floor(nbResults/5)) $(this).hide();
		search();
	});

	$("#previous").click(function(){
		page--;
		$("#next").show();
		if(page==0) $(this).hide();
		search();
	});

	$(document).on("click",".soumettre", function(){
		let idSondage = $(this).attr("id").substr("soumettre".length);
		let choix = $('input[name="'+idSondage+'"]:checked').attr("id").substr("choix".length);
		$.ajax({
			type: "POST",
			url: "./minControleur/dataAccueil.php",
			data: {"action":"vote", "idSondage":idSondage, "choix":choix},
			success: function(oRep){
				console.log(oRep);
				$("#soumettre"+idSondage).remove();
				let i = 1;
				$('.reponse', $("#reponse"+idSondage)).each(function () {
					//$(this).find(".progress").remove();
					let choix = $(this).find("label").html();
					$(this).empty();
					$(this).append(`<div>`+choix+`</div>`);
					let pourcentage;
					if(oRep[0]==0 || oRep[i]==0) pourcentage=0;
					else pourcentage = Math.round((oRep[i]/oRep[0])*100);
					if(pourcentage!=0)
						$(this).append(`
						<div class="progress">
							<div class="progress-bar bg-warning" role="progressbar" style="width: `+pourcentage+`%" aria-valuenow="`+pourcentage+`>" aria-valuemin="0" aria-valuemax="100">`+pourcentage+`%</div>
						</div>
						`)
					else 
						$(this).append(`
						<div class="progress">
							<span style='margin-left:20px; color: #fff;'>`+pourcentage+`%</span>
							<div class="progress-bar bg-warning" role="progressbar" style="width: `+pourcentage+`%" aria-valuenow="`+pourcentage+`>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						`)
					i++;
				});
			},
			dataType: "json"
		});
	});

	$(document).on("click",".suppr", function(){
		$("#toSuppr").val($(this).attr("id").substr("suppr".length));
	});


	$(document).on("click","#confirmSuppr", function(){
		let idAnnonce = $("#toSuppr").val();
		$.ajax({
			type: "POST",
			url: "./minControleur/dataAccueil.php",
			data: {"action":"suppr", "idAnnonce":idAnnonce},
			success: function(oRep){
				console.log(oRep);
				document.location.href="index.php?view=accueil";
			},
			dataType: "text"
		});
	});

	$(document).on("click",".epingle",function(){
		var id = $(this).attr('id').substr(7);
		var epingle = $(this);
		$.ajax({
			type: "POST",
			url: "./minControleur/dataAccueil.php",
			data: {"action":"epinlger", "id":id},
			success: function(oRep){
				document.location.reload();
			},
			dataType: "text"
		});



	});

});

function resetVideoHeight() {
	//console.log("On resize");
	$(".video").css("height", $("#video").width() * 9/16);
}

function checkVideo(){
	var heightG = $("#gaucheM").height();
	var heightD = countDivDroite();
	var diffHeight = heightG - heightD;
	

	while (diffHeight > 180 && !checkModeResponsive()) { // on peut ajouter une vidéo si >180 et pas mode responsive
		insertRandomVideo();
		diffHeight-=180; // on regarde si on peut encore ajouter
	} 
}

function insertRandomVideo() {
	$("#titleVideo").html('Vidéos aléatoires.');
	$.ajax({
		type: "POST",
		url: "./minControleur/dataAccueil.php",
		data: {"action":"getRandomVideo"},
		success: function(oRep){
			var div = `<div class = "wrapper center mt-4 newVideo" style="width:100%">							
							<iframe id="video" class="w100" width="80%" height="" src="//www.youtube.com/embed/` + oRep +`" frameborder="0" allowfullscreen></iframe>
						</div>`;

			
			$("#divTwitter").before(div);
		},
		dataType: "json"
	});
}

function countDivDroite(){
	var sum=0;
	$("#droiteM > *").each(function(){
		sum+=$(this).outerHeight(true);
	});
	return sum;
}


$(window).resize(function() {
	setTimeout(function() {
		var flag = checkModeResponsive();
		if (!flag) // on est pas en mode responsive
			checkVideo(); // on regarde si on peut insérer une video
	}, 2000);

});

function checkModeResponsive(){
	var width = $(window).width();
	if (width < 752){ // on supprime les nouvelles vidéos car mode responsive
		$(".newVideo").remove();
		$("#titleVideo").html('Dernière vidéo');
		return true;
	}
	return false;
}