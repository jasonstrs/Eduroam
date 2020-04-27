var nbPage;
var progress;

$(function(){

    if($("#selectSerie").children("option").length==0) {
        $("#noSerie").show();
        $("#chooseSeries").hide();
        $("#deleteSerie").hide();
        $("#regex").hide();
    }
    else {
        $("#noSerie").hide();
        $("#chooseSeries").show();
        $("#deleteSerie").show();
        $("#regex").show();
    }

    $("#actualiser").on( "click", function( event ) {
        progress=0;
        $("#actualiserProgress").attr("aria-valuenow", 0);
        $("#actualiserProgress").css("width", 0);
		callApi();
    });
    
    $("#newSerie").on( "click", function( event ) {
        console.log("test ?")
        $("#series").hide();
        $("#createSerie").show();
        $("#regex").hide();
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
                    $("#regex").hide();
                }
                $("#selectSerie").change();
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
                $("#regex").show();
                $("#chooseSeries").show();
                $("#noSerie").hide();
                //$("#chooseSeries").children("option:selected");
                $("#selectSerie").append("<option value='"+data+"'>"+nomSerie+"</option>");
                $("#selectSerie").val(data);
                $("#selectSerie").change();
            },
        });
        $("#nomSerie").val("");
    });

    $("#cancelSerie").on( "click", function( event ) {
        $("#series").show();
        $("#createSerie").hide();
        $("#nomSerie").val("");
        $("#regex").show();
    });

    $("#nomSerie").keyup(function(e){
        if(e.keyCode==13) {
            $("#creerSerie").click();
        }
        if(e.keyCode==27) {
            $("#cancelSerie").click();
        }
    });

    $(document).on("click",".regex", function(){
        $(".selectedRegex").removeClass("selectedRegex");
        $(this).addClass("selectedRegex");
        console.log("test")
    });

    $('body').click(function(evt){    
        //console.log(evt)
        if(evt.target.id.substr(0,5) == "regex")
           return;
        if(evt.target.id == "suppId")
           return;
        
        $(".selectedRegex").removeClass("selectedRegex");
    });

    let editRegex = $(`<input type="text" class="editRegex"></input>`);
    editRegex.on("blur", function(){
        console.log("On pert le focus")
        saveRegex($(this));
    });
    editRegex.on("keyup", function(e){
        if(e.keyCode==27) {
            if($(this).hasClass("newRegex")); {
                $(this).off('blur');
                $(this).remove();
            }
        } 
        if(e.keyCode==13) {
            $(this).off('blur');
            saveRegex($(this));
        }
    });

    $(document).on("dblclick",".regex", function(){
        let editingRegex = editRegex.clone(true);
        editingRegex.val($.trim($(this).text()));
        editingRegex.data("id", $(this).attr("id").substr(5));
        console.log(editingRegex.data("id"));
        $(this).replaceWith(editingRegex);
        editingRegex.focus();
    });

    $("#selectSerie").change(function(){
        $.ajax({
            type: "POST",
            url: "./minControleur/dataVideoAdmin.php",
            data: {"action":"getRegex", "id":$(this).val()},
            dataType : 'json',
            success : function(data){
                console.log(data);
                $(".regex").remove();
                for(let i = 0; i<data.length; i++) 
                    $("#regexTab").append(`<p class="regex" id="regex`+data[i].id_regex+`"> `+data[i].regex+` </p>`);
            },
        });
    });

    $("#addId").click(function(){
        let newRegex = editRegex.clone(true).addClass("newRegex")
        $("#regexTab").append(newRegex);
        $(".newRegex").focus();
    });

    $("#suppId").click(function(){
        if($(".selectedRegex").length==1) {
            let id = $(".selectedRegex").attr("id").substr(5)
            $.ajax({
                type: "POST",
                url: "./minControleur/dataVideoAdmin.php",
                data: {"action":"deleteRegex", "id":id},
                dataType : 'text',
                success : function(data){
                    console.log(data);
                    $(".selectedRegex").remove();
                },
            });
        }
        else console.log("erreur");
    });
})

function saveRegex($ref) {
    let val = $.trim($ref.val());
    if(/\S/.test(val)) {
        if($ref.hasClass("newRegex")) {
            let $new = $(`<p class="regex" id="regex">`+val+`</p>`);
            $ref.replaceWith($new);
            $.ajax({
                type: "POST",
                url: "./minControleur/dataVideoAdmin.php",
                data: {"action":"addRegex", "serie":$("#selectSerie").val(), "regex":val},
                dataType : 'text',
                success : function(data){
                    console.log(data);
                    $new.attr("id","regex"+data);
                },
            });
        }
        else {
            let id = $ref.data("id");
            let $new = $(`<p class="regex" id="regex`+id+`">`+val+`</p>`);
            $ref.replaceWith($new);
            $.ajax({
                type: "POST",
                url: "./minControleur/dataVideoAdmin.php",
                data: {"action":"editRegex", "id":id, "regex":val},
                dataType : 'text',
                success : function(data){
                    console.log(data);
                },
            });
        }
    }
    else $ref.remove();
}

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
        nbPage=results.pageInfo.totalResults/results.pageInfo.resultsPerPage;
        progress++;
        $("#actualiserProgress").attr("aria-valuenow", 100/nbPage*progress);
        $("#actualiserProgress").css("width", 100/nbPage*progress+"%");
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
            $('#actualiserModal').modal('hide')
		},
		dataType: "text"
	});
}

function init() {
	gapi.client.setApiKey("AIzaSyBJ0QWmqfhRruL_iy1U5KAoCy4yPbxoHxk");
	gapi.client.load("youtube", "v3", function() {});
}