function tplawesome(e,t){res=e;for(var n=0;n<t.length;n++){res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){return t[n][r]})}return res}

$(function() {
	resetVideoHeight();
	$(window).on("resize", resetVideoHeight);

	$("#search-button").on( "click", function( event ) {
		location.href='index.php?view=video&search='+$("#search").val();
	});

	$("#search").keydown(function(event) {
		if (event.keyCode == '13') $("#search-button").click();
	});

	$("iframe#myId").load(function(){
		console.log("titre : " +$(".ytp-title-link").html());
		$("#title").html($(".ytp-title-link").html());
	});

});

function callApi() {
	// prepare the request
	var request = gapi.client.youtube.search.list({
		part: "snippet",
		type: "video",
		maxResults: 11,
		order: "viewCount",
		channelId: "UC9NB2nXjNtRabu3YLPB16Hg",
		pageToken: $("#pageToken").val(),
		//relatedToVideoId: $("#videoId").val(),
	}); 
	// execute the request
	request.execute(function(response) {
		var i=0;
		console.log(response);
		var results = response.result;
		$("#results").html("");
		$("#next").data("token", results.nextPageToken);
		$("#prev").data("token", results.prevPageToken);
		$.each(results.items, function(index, item) {
			if(item.id.videoId!=$("#videoId").val() && i!=10) {
				i++;
				var vid=$("<li>").addClass("media item");
				vid.append($("<div>").addClass("item-img").append($("<a>").attr("href", 'index.php?view=watchvideo&id='+item.id.videoId).append($("<img>").attr("src", item.snippet.thumbnails.default.url))));
				vid.append($("<div>").addClass("media-body item-txt").append($("<a>").attr("href", 'index.php?view=watchvideo&id='+item.id.videoId).append($("<span>").html(item.snippet.title))));
				$("#results").append(vid);
			}
		});
		if (typeof response.prevPageToken === "undefined") {$("#prev").prop( "disabled", true );}else{$("#prev").prop( "disabled", false );}
		if (typeof response.nextPageToken === "undefined") {$("#next").prop( "disabled", true );}else{$("#next").prop( "disabled", false );}
		if (typeof response.nextPageToken === "undefined" && typeof response.prevPageToken === "undefined") {
			$("#next").hide();
			$("#prev").hide();
		} else {
			$("#next").show();
			$("#prev").show();
		}
		resetVideoHeight();
	});
}

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

function resetVideoHeight() {
	//console.log("On resize");
	$(".video").css("height", $("#video").width() * 9/16);
}

function init() {
	gapi.client.setApiKey("AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk");
	gapi.client.load("youtube", "v3", function() {
		console.log($("#videoId").val());
		callApi();
		getInfos();
	});
}
//AIzaSyAAt7wGTR0i4T7H0IXmFfheOo9mzG1nK58

//Clef Jason :
//AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk
