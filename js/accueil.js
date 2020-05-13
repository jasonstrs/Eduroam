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

});

function resetVideoHeight() {
	//console.log("On resize");
	$(".video").css("height", $("#video").width() * 9/16);
}
