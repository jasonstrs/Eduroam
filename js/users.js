$("#userSearch").keyup(function(){
    if(!$("#userSearch").val().length==0) {
        autocomplete();
    }
    else $("#userResult").empty();
})

function addResult(obj, number) {
    let div = `<div class="userResult" id="user`+obj.idU+`">`+ obj.prenom +` `+ obj.nom +` (`+ obj.email + `)</div>`;
    $("#userResult").append(div);
    $("#user"+obj.idU).css({ 
        top: parseInt((number)*41)
    })
}

function autocomplete(){
    $.ajax({
        type: "POST",
        url: "./minControleur/dataUsers.php",
        data: {"action": "search", "tag": $("#userSearch").val()},
        success: function(oRep){
            //console.log(oRep);
            $("#userResult").empty();
            for(let i=0; i<oRep.length; i++) {
                addResult(oRep[i], i);
            }
        },
        dataType: "json"
    });
}

$("#userSearch").focusin(function(){
    if(!$("#userSearch").val().length==0) {
        autocomplete();
    }
})

$(".userResult").click(function(){
})

$("#userSearch").focusout(function(){
    $("#userResult").empty();
})