function tplawesome(e,t){res=e;for(var n=0;n<t.length;n++){res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){return t[n][r]})}return res}

function escapeHtml(text) {
	return text
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#039;");
  }

$(function() {
	insertSearch();
	resetVideoHeight();
	$(window).on("resize", resetVideoHeight);

	$("#search-button").on( "click", function( event ) {
		location.href='index.php?view=video&search='+escapeHtml($("#search").val());
	});

	$("#search").keydown(function(event) {
		if (event.keyCode == '13') $("#search-button").click();
	});

});

function getInfos() {
/* 	// prepare the request
	var request = gapi.client.youtube.videos.list({
		part: ,
		id: $("#videoId").val(),
	}); 
	// execute the request
	request.execute(function(response) {
		console.log(response);
	}); */
	
}

function insertSearch() {
	$("#results").load("./templates/videosearch.php", {
		videoParPage : 10,
		notID: $("#videoId").val(),
		type : "watchvideo",
		date : $("#videoDate").val(),
	});
}

function resetVideoHeight() {
	//console.log("On resize");
	$(".video").css("height", $("#video").width() * 9/16);
}

//AIzaSyAAt7wGTR0i4T7H0IXmFfheOo9mzG1nK58

//Clef Jason :
//AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk
