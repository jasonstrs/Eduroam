$(function(){

    if($("#selectSerie").children("option").length==0) {
        $("#noSerie").show();
        $("#chooseSeries").hide();
        $("#deleteSerie").hide();
    }
    else {
        $("#noSerie").hide();
        $("#chooseSeries").show();
        $("#deleteSerie").show();
    }

    $("#actualiser").on( "click", function( event ) {
		callApi();
    });
    
    $("#newSerie").on( "click", function( event ) {
        console.log("test ?")
        $("#series").hide();
        $("#createSerie").show();
    });

    $("#deleteSerie").on( "click", function( event ) {
        let id=$("#selectSerie").val();
        $.ajax({
            type: "POST",
            url: "./minControleur/dataVideoAdmin.php",
            data: {"action":"delete", "id":id},
            dataType : 'text',
            success : function(data){
                console.log(data);
                $("#selectSerie").children('option[value="'+id+'"]').remove();
                if($("#selectSerie").children("option").length==0) {
                    $("#noSerie").show();
                    $("#chooseSeries").hide();
                }
            },
        });
    });
    
    $("#creerSerie").on( "click", function( event ) {
        $("#series").show();
        $("#createSerie").hide();
        let nomSerie = $("#nomSerie").val();
        $.ajax({
            type: "POST",
            url: "./minControleur/dataVideoAdmin.php",
            data: {"action":"add", "nom":nomSerie},
            dataType : 'text',
            success : function(data){
                $("#chooseSeries").show();
                $("#noSerie").hide();
                //$("#chooseSeries").children("option:selected");
                $("#selectSerie").append("<option value='"+data+"'>"+nomSerie+"</option>");
                $("#selectSerie").val(data);
            },
        });
        $("#nomSerie").val("");
    });

    $("#cancelSerie").on( "click", function( event ) {
        $("#series").show();
        $("#createSerie").hide();
        $("#nomSerie").val("");
    });

    $("#nomSerie").keyup(function(e){
        if(e.keyCode==13) {
            $("#creerSerie").click();
        }
        if(e.keyCode==27) {
            $("#cancelSerie").click();
        }
    })
})

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
	gapi.client.load("youtube", "v3", function() {});
}