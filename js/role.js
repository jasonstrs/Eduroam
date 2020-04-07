$(document).on("click",".editing", function(){
	//console.log("On click sur un .editing");
	let $collapse=$($(this).attr("href"));
	let $roleForm=$("#roleForm");
	let id=$(this).attr("idRole");
	$(this).addClass("edit").removeClass("editing").html("<i class='fas fa-pen'></i>");
	$(this).next().addClass("remove").removeClass("cancel").html("<i class='fas fa-trash-alt' style='color:red;'></i>");
	$(".edit").show();
	$(".remove").show();
	$(".new").css("color","black");
	$(".new").css("cursor","pointer");
	let video = $("#video").prop("checked") ? 1 : 0;
	let spectacle = $("#spectacle").prop("checked") ? 1 : 0;
	let user = $("#user").prop("checked") ? 1 : 0;
	let annonce = $("#annonce").prop("checked") ? 1 : 0;
	$.ajax({
		type: "POST",
		url: "./minControleur/dataRole.php",
		data: {"action": "edit", "idRole": id, "nom": $("#name").val(), "droits":{"video": video, "spectacle": spectacle, "utilisateurs": user, "annonce": annonce,}},
		success: function(oRep){
			setTimeout(function(){
				updateRole(id, $("#name").val(), video, spectacle, user, annonce);
			},150)
			//console.log("Fini.");
		},
		dataType: "text"
	});
	$collapse.collapse('toggle');
});

$(document).on("click",".edit", function(){
	//console.log("On click sur un .edit");
	let $collapse=$($(this).attr("href"));
	let $roleForm=$("#roleForm");
	$(this).addClass("editing").removeClass("edit").html("<i class='fas fa-check' style='color:green;'></i>");
	$(this).next().addClass("cancel").removeClass("remove").html("<i class='fas fa-times' style='color:red;'></i>");
	$roleForm.show();
	$("#name").val($collapse.attr("roleName"));
	if($collapse.attr("video")==1) $("#video").prop("checked", true);
	else $("#video").prop("checked", false);
	if($collapse.attr("spectacle")==1) $("#spectacle").prop("checked", true);
	else $("#spectacle").prop("checked", false);
	if($collapse.attr("user")==1) $("#user").prop("checked", true);
	else $("#user").prop("checked", false);
	if($collapse.attr("annonce")==1) $("#annonce").prop("checked", true);
	else $("#annonce").prop("checked", false);
	$collapse.append($roleForm);
	$(".edit").hide();
	$(".remove").hide();
	$(".new").css("color","darkgrey");
	$(".new").css("cursor","not-allowed");
	$collapse.collapse('toggle');
});

$(document).on("click",".remove", function(){
	let div=$("#role"+$(this).attr("idRole"));
	let $roleForm=$("#roleForm");
	$.ajax({
		type: "POST",
		url: "./minControleur/dataRole.php",
		data: {"action":"delete", "idRole":$(this).attr("idRole")},
		success: function(oRep){
			$("#collapseNew").append($roleForm);
			div.remove();
			//console.log("Fini.");
		},
		dataType: "text"
	});
});

$(document).on("click",".cancel", function(){
	$(this).addClass("remove").removeClass("cancel").html("<i class='fas fa-trash-alt' style='color:red;'></i>");
	$(this).prev().addClass("edit").removeClass("editing").html("<i class='fas fa-pen'></i>");
	$($(this).prev().attr("href")).collapse('toggle');
	$(".edit").show();
	$(".remove").show();
	$(".new").css("color","black");
	$(".new").css("cursor","pointer");
});

$(document).on("click",".new", function(){
	//console.log("On click sur un .New");
	let $collapse=$("#collapseNew");
	let $roleForm=$("#roleForm");
	if(!$(".editing").length) {
		$(this).addClass("editingNew").removeClass("new").html("<i class='fas fa-check' style='color:green;'></i>");
		$(this).next().html("<i class='fas fa-times' style='color:red;'></i>");
		$roleForm.show();
		$("#name").val("");
		$("#video").prop("checked", false);
		$("#spectacle").prop("checked", false);
		$("#user").prop("checked", false);
		$("#annonce").prop("checked", false);
		$collapse.append($roleForm);
		$(".edit").hide();
		$(".remove").hide();
		$collapse.collapse('toggle');
	}
});

$(document).on("click",".editingNew", function(){
	//console.log("On click sur un .editingNew");
	let $collapse=$("#collapseNew");
	let $roleForm=$("#roleForm");
	if ($("#name").val().replace(/^\s+|\s+$/g, "").length != 0){
		$(this).addClass("new").removeClass("editingNew").html("<i class='fas fa-plus'></i>");
		$(this).next().html("");
		$(".edit").show();
		$(".remove").show();
		let video = $("#video").prop("checked") ? 1 : 0;
		let spectacle = $("#spectacle").prop("checked") ? 1 : 0;
		let user = $("#user").prop("checked") ? 1 : 0;
		let annonce = $("#annonce").prop("checked") ? 1 : 0;
		$.ajax({
			type: "POST",
			url: "./minControleur/dataRole.php",
			data: {"action":"add", "nom":$("#name").val(), "droits":{"video": video, "spectacle": spectacle, "utilisateurs": user, "annonce": annonce,}},
			success: function(oRep){
				//console.log("Wtf mon bro ?");
				updateRole(parseInt(oRep), $("#name").val(), video, spectacle, user, annonce)
			},
			dataType: "text"
		});
		$collapse.collapse('toggle');
	}
	else {
		$("#name").addClass("is-invalid");
		$("#nameError").show();
	}
	return false;
});

$(document).on("click",".cancelNew", function(){
	$(this).html("");
	$(this).prev().addClass("new").removeClass("editingNew").html("<i class='fas fa-plus'></i>");
	$("#collapseNew").collapse('toggle');
	resetError();
	$(".edit").show();
	$(".remove").show();
})

$("#name").change(function(){
	resetError();
})

function resetError() {
	$("#name").removeClass("is-invalid");
	$("#nameError").hide();
}

function updateRole(id, name, video, spectacle, user, annonce) {
	let $roleForm=$("#roleForm");
	$("#collapseNew").append($roleForm);
	let div = "";
	if(!$("#role"+id).length) {
		div += `<div class="mt-2" id="role`+id+`">`
	}
	div += `<div class="row">
				<div class="col-5 offset-3 list-role">
				`+name+`
				</div>
				<div class="col-2 text-right list-role">
					<a class="edit text-decoration-none text-body m-3" href="#collapse`+id+`" idRole="`+id+`">
						<i class="fas fa-pen"></i>
					</a>
					<a href="#" class="remove text-decoration-none text-body" idRole="`+id+`">
						<i class="fas fa-trash-alt" style="color:red;"></i>
					</a>
				</div>      
			</div>
			<div class="collapse" id="collapse`+id+`" roleName="`+name+`" 
			video="`+video+`" spectacle="`+spectacle+`" 
			user="`+user+`" annonce="`+annonce+`">
			</div>`
	if(!$("#role"+id).length) {
		div += `</div>`
		$("#createRole").before(div);
	}
	else {
		$("#role"+id).html(div);
	}
}