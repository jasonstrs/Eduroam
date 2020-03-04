

$(function() {

	$("#posteAvant").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd",
	});

	$("#posteApres").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd",
	});

	$("#posteAvant").change(function(){
		var today = new Date($(this).val());
		//var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		console.log(today.toString());
	})
	

	$("form").on("submit", function(e) {
		e.preventDefault();
		resetPagination();
		$("#pageToken").val("");
		insertSearch();
		if($("#search").val())
			history.pushState("", "",  "index.php?view=video&search="+$("#search").val());
		else 
			history.pushState("", "",  "index.php?view=video");
		
	});

	$("#search-button").on( "click", function( event ) {
		resetPagination();
		$("#pageToken").val("");
		insertSearch();
		if($("#search").val())
			history.pushState("", "",  "index.php?view=video&search="+$("#search").val());
		else 
			history.pushState("", "",  "index.php?view=video");
	});

	$("#actualiser").on( "click", function( event ) {
		callApi();
	});

	$("#next").hide();
	$("#prev").hide();
	$("#prev").prop( "disabled", true );
	$("#next").prop( "disabled", true );
	/* $(document).on("mouseover","*", function(){
		console.log($(this).data());
	}); */

	//$(window).on("resize", resetVideoHeight);
});

function callApi(nToken) {
	var nextToken = nToken;
	// prepare the request
	var request = gapi.client.youtube.search.list({
		part: "snippet",
		type: "video",
		maxResults: 50,
		order: "date",
		//publishedAfter: "2015-01-01T00:00:00Z",
		channelId: "UC9NB2nXjNtRabu3YLPB16Hg",
		pageToken: nextToken,
	});
	// execute the request
	request.execute(function(response) {
		//console.log(response);
		var flag = 0;
		var results = response.result;
		//var tab = {'1':'test','2':{'1':'lol','2':'mdr'},'3':'test3'};
		//console.log(tab);
		if(results.items.length==0) {
			console.log("Fini par items.length");
			endApi();
		}
		else {
			$.ajax({
				type: "POST",
				url: "./minControleur/dataVideo.php",
				data: {"action":"add", "videos":response},
				success: function(oRep){
					console.log(oRep);
					nextToken = oRep;
					if (typeof response.nextPageToken !== "undefined") {
						nextToken = response.nextPageToken;
						//console.log(nextToken);
						callApi(nextToken);
					}
					else {
						console.log("Fini par nextPageToken");
						endApi();
					}
				},
				dataType: "text"
			});
		}
		/*$.each(results.items, function(index, item) {
			var vid=$("<li>").addClass("media item");
			vid.append($("<div>").addClass("item-img").append($("<a>").attr("href", 'index.php?view=watchvideo&id='+item.id.videoId).append($("<img>").attr("src", item.snippet.thumbnails.default.url))));
			vid.append($("<div>").addClass("media-body item-txt").append($("<a>").attr("href", 'index.php?view=watchvideo&id='+item.id.videoId).append($("<span>").html(item.snippet.title))));
			$("#results").append(vid);
		});*/
	});
}

function endApi() {
	$.ajax({
		type: "POST",
		url: "./minControleur/dataVideo.php",
		data: {"action":"check"},
		success: function(oRep){
			console.log("Fini.")
		},
		dataType: "text"
	});
}

function init() {
	gapi.client.setApiKey("AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk");
	gapi.client.load("youtube", "v3", function() {
		insertSearch();
		resetPagination();
	});
}

function insertSearch() {
	$("#results").load("./templates/videosearch.php", {
		search : $("#search").val(),
		page : $('#hiddenpage').val()-1,
		videoParPage : nbVid,
		type : "video",
	});
}

//AIzaSyAAt7wGTR0i4T7H0IXmFfheOo9mzG1nK58

//Clef Jason :
//AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk

var $lipagination = $('.page-number');
var $lipaginup = $('.page-up');
var $lipagindown = $('.page-down');
var nbVid = 25;

function countVideos() {
	$.ajax({
		type: "POST",
		url: "./minControleur/dataVideo.php",
		data: {"action":"count", "search":$("#search").val()},
		dataType : 'text',
		async: false, //On met en synchrone sinon la requête arrive trop tard pour être réutilisée par la fonction pagination()
	   
	   
		success : function(data){
			//console.log(data);
			$("#nbserie").val(data);
		},
	   
    });
}

function cleanActive() {
	$lipagination.each(function (i) {
		$(this).removeClass("active");
	});
}

function resetPagination() {
	countVideos();
	$('#hiddenpage').val(1);
	pagination();
}

function pagination() {
	cleanActive();
	var page=$('#hiddenpage').val();
	//console.log(page);
	var nbSerie=$('#nbserie').val();
	//console.log(nbSerie);
	var nbSeriePage = nbVid;
	var nbPage = Math.ceil(nbSerie / nbSeriePage); 
	//console.log(nbPage);
	var pageinf2 = parseInt(page) - 2;
	var pageinf1 = parseInt(page) - 1;
	var pagesup1 = parseInt(page) + 1;
	var pagesup2 = parseInt(page) + 2;
	//console.log(pagesup1);
	
	if(nbPage<=1) $('#pagination').hide();
	else $('#pagination').show();
	if(nbPage==2 && page==nbPage) { $('#pageinf').hide(); $('#pagesup').show();}
	if(nbPage==2 && page==1) { $('#pagesup').hide(); $('#pageinf').show();} 
	if(nbPage>2) { $('#pagesup').show(); $('#pageinf').show();} 
	
	if(page==1) {
		$('#previouspageli').toggleClass('disabled');
		$('#pageinf').text(page);
		$('#pageinfli').toggleClass("active");
		$('#pagemid').text(pagesup1);
		$('#pagesup').text(pagesup2);
		$('#nextpageli').removeClass('disabled');
	} else if(page==nbPage) {
		$('#previouspageli').removeClass('disabled');
		$('#pageinf').text(pageinf2);
		$('#pagemid').text(pageinf1);
		$('#pagesup').text(page);
		$('#pagesupli').toggleClass("active");
		$('#nextpageli').toggleClass('disabled');
	} else {
		$('#previouspageli').removeClass('disabled');
		$('#pageinf').text(pageinf1);
		$('#pagemid').text(page);
		$('#pagemidli').toggleClass("active");
		$('#pagesup').text(pagesup1);
		$('#nextpageli').removeClass('disabled');
	}
}

$lipagination.click(function(){
	$('#hiddenpage').val($(this.children).text());
	insertSearch();
	pagination();
});

$lipaginup.click(function(){
	if(!$(this).hasClass( "disabled" )) {
	var nbSerie=$('#nbserie').val();
	var nbSeriePage = nbVid;
	var nbPage = Math.ceil(nbSerie / nbSeriePage);
	console.log(nbPage);
	$('#hiddenpage').val(nbPage);
	insertSearch();
	pagination();
	}
	else console.log("Ce bouton est désactivé");
});

$lipagindown.click(function(){
	if(!$(this).hasClass( "disabled" )) {
	$('#hiddenpage').val(1);
	insertSearch();
	pagination();
	}
	else console.log("Ce bouton est désactivé");
});

$("#pagination").ready(function(){
	insertSearch();
	pagination();
});