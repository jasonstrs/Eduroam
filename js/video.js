function tplawesome(e,t){res=e;for(var n=0;n<t.length;n++){res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){return t[n][r]})}return res}

$(function() {
	$("form").on("submit", function(e) {
		e.preventDefault();
		$("#pageToken").val("");
		callApi();
		if($("#search").val())
			history.pushState("", "",  "index.php?view=video&search="+$("#search").val());
		else 
			history.pushState("", "",  "index.php?view=video");
	});

	$("#search-button").on( "click", function( event ) {
		$("#pageToken").val("");
		callApi();
		if($("#search").val())
			history.pushState("", "",  "index.php?view=video&search="+$("#search").val());
		else 
			history.pushState("", "",  "index.php?view=video");
	});

	$("#next").on( "click", function( event ) {
		$("#pageToken").val($("#next").data("token"));
		callApi();
	});

	$("#prev").on( "click", function( event ) {
		$("#pageToken").val($("#prev").data("token"));
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

function callApi() {
	// prepare the request
	var request = gapi.client.youtube.search.list({
		part: "snippet",
		type: "video",
		q: encodeURIComponent($("#search").val()).replace(/%20/g, "+"),
		maxResults: 10,
		order: "date",
		//publishedAfter: "2015-01-01T00:00:00Z",
		channelId: "UC9NB2nXjNtRabu3YLPB16Hg",
		//forMine: true,
		pageToken:$("#pageToken").val(),
	}); 
	// execute the request
	request.execute(function(response) {
		console.log(response);
		var results = response.result;
		$("#next").data("token", results.nextPageToken);
		$("#prev").data("token", results.prevPageToken);
		if(results.items.length==0) {
			$("#pageToken").val($("#prev").data("token"));
			$("#next").prop( "disabled", true );
		}
		else {
			$("#results").html("");
			if (typeof response.prevPageToken === "undefined") {$("#prev").prop( "disabled", true );}else{$("#prev").prop( "disabled", false );}
			if (typeof response.nextPageToken === "undefined") {$("#next").prop( "disabled", true );}else{$("#next").prop( "disabled", false );}
		}
		$.each(results.items, function(index, item) {
			var vid=$("<li>").addClass("media item");
			vid.append($("<div>").addClass("item-img").append($("<a>").attr("href", 'index.php?view=watchvideo&id='+item.id.videoId).append($("<img>").attr("src", item.snippet.thumbnails.default.url))));
			vid.append($("<div>").addClass("media-body item-txt").append($("<a>").attr("href", 'index.php?view=watchvideo&id='+item.id.videoId).append($("<span>").html(item.snippet.title))));
			$("#results").append(vid);
			/* $.get("tpl/item.html", function(data) {
				$("#results").append(tplawesome(data, [{"title":item.snippet.title, "videoid":item.id.videoId}]));
			}); */
		});
		
		if (typeof response.nextPageToken === "undefined" && typeof response.prevPageToken === "undefined") {
			$("#next").hide();
			$("#prev").hide();
		} else {
			$("#next").show();
			$("#prev").show();
		}
		//resetVideoHeight();
	});
}

function resetVideoHeight() {
	$(".video").css("height", $("#results").width() * 9/16);
}

function init() {
	gapi.client.setApiKey("AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk");
	gapi.client.load("youtube", "v3", function() {
		callApi();
	});
}
//AIzaSyAAt7wGTR0i4T7H0IXmFfheOo9mzG1nK58

//Clef Jason :
//AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk
