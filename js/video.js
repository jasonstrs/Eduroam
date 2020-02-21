function tplawesome(e,t){res=e;for(var n=0;n<t.length;n++){res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){return t[n][r]})}return res}

$(function() {
	$("form").on("submit", function(e) {
		e.preventDefault();
		$("#pageToken").val("");
		//callApi();
		if($("#search").val())
			history.pushState("", "",  "index.php?view=video&search="+$("#search").val());
		else 
			history.pushState("", "",  "index.php?view=video");
	});

	$("#search-button").on( "click", function( event ) {
		$("#pageToken").val("");
		//callApi();
		if($("#search").val())
			history.pushState("", "",  "index.php?view=video&search="+$("#search").val());
		else 
			history.pushState("", "",  "index.php?view=video");
	});

	$("#next").on( "click", function( event ) {
		$("#pageToken").val($("#next").data("token"));
		//callApi();
	});

	$("#prev").on( "click", function( event ) {
		$("#pageToken").val($("#prev").data("token"));
		//callApi();
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
		console.log(response);
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
				url: "./minControleur/video.php",
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
		url: "./minControleur/video.php",
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
		//callApi();
	});
}
//AIzaSyAAt7wGTR0i4T7H0IXmFfheOo9mzG1nK58

//Clef Jason :
//AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk
