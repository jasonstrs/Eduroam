$("#userSearch").keyup(function(){
    console.log("On a changé le truc");
    console.log($("#userSearch").val());
    if(!$("#userSearch").val().length==0) {
        $.ajax({
            type: "POST",
            url: "./minControleur/dataUsers.php",
            data: {"action": "search", "tag": $("#userSearch").val()},
            success: function(oRep){
                console.log(oRep);
                $("#userResult").empty();
                for(let i=0; i<oRep.length; i++) {
                    addResult(oRep[i]);
                }
            },
            dataType: "json"
        });
    }
    else $("#userResult").empty();
})

function addResult(obj) {
    let div = `<div class="userResult" id="user`+obj.idU+`">`+ obj.prenom +` `+ obj.nom +` (`+ obj.email + `)</div>`;
    $("#userResult").append(div);
}