var historique = [];

$("#userSearch").keyup(function(){
    if(!$("#userSearch").val().length==0) {
        autocomplete();
    }
    else $("#userResult").empty();
});

function addResult(obj, number, tag="") {
    let prenom = "";
    let nom = "";
    let email = "";
    //On retire les accents et on met tout en minuscule
    let prenomTest = obj.prenom.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    let nomTest = obj.nom.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    let emailTest = obj.email.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    let tagTest = tag.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    //On met en gras ce qui correspond
    /* prenom = prenomTest.substr(0, tag.length) == tagTest ? "<strong>"+obj.prenom.substr(0, tag.length)+"</strong>"+obj.prenom.substr(tag.length) : obj.prenom;
    nom = nomTest.substr(0, tag.length) == tagTest ? "<strong>"+obj.nom.substr(0, tag.length)+"</strong>"+obj.nom.substr(tag.length) : obj.nom; */
    //email = emailTest.substr(0, tag.length) == tagTest ? "<strong>"+obj.email.substr(0, tag.length)+"</strong>"+obj.email.substr(tag.length) : obj.email;
    let prenomNomTest = prenomTest+" "+nomTest+" ("+emailTest+")";
    let nomPrenomTest = nomTest+" "+prenomTest+" ("+emailTest+")";
    let emailPrenomTest = emailTest+" ("+prenomTest+" "+nomTest+")";
    if(prenomNomTest.substr(0, tag.length) == tagTest){
        let prenomNom = obj.prenom +" "+ obj.nom+" ("+obj.email+")";
        prenomNom = "<strong>"+prenomNom.substr(0, tag.length)+"</strong>"+prenomNom.substr(tag.length);
        let tab = prenomNom.split(" ");
        prenom = tab[0];
        nom = tab[1];
        email = tab[2];
    }
    else if(nomPrenomTest.substr(0, tag.length) == tagTest){
        let nomPrenom = obj.nom +" "+ obj.prenom+" ("+obj.email+")";
        nomPrenom = "<strong>"+nomPrenom.substr(0, tag.length)+"</strong>"+nomPrenom.substr(tag.length);
        let tab = nomPrenom.split(" ");
        prenom = tab[0];
        nom = tab[1];
        email = tab[2];
    }
    else if(emailPrenomTest.substr(0, tag.length) == tagTest) {
        let emailPrenom = obj.email +" ("+ obj.prenom+" "+obj.nom+")";
        emailPrenom = "<strong>"+emailPrenom.substr(0, tag.length)+"</strong>"+emailPrenom.substr(tag.length);
        let tab = emailPrenom.split(" ");
        prenom = tab[0];
        nom = tab[1];
        email = tab[2];
    }
    let div = `<div class="userResult" id="user`+obj.idU+`">`+ prenom +` `+ nom +` `+ email +`</div>`;
    $("#userResult").append(div);
    $("#user"+obj.idU).css({ 
        top: parseInt((number)*41)
    })
    $("#user"+obj.idU).data("oRep", obj);
}

function autocomplete(){
    //console.log(historique);
    let tag=$("#userSearch").val();
    let tagClean = tag.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    let flag=-1;
    for(let j=0; j<historique.length; j++) {
        //console.log(tagClean+" = "+historique[j].tag+" ?");
        if(tagClean==historique[j].tag) {
            //console.log("true");
            flag=j;
            break;
        }
    }
    if(flag==-1) {
        //console.log("On va chercher dans la bdd");
        $.ajax({
            type: "POST",
            url: "./minControleur/dataUsers.php",
            data: {"action": "search", "tag": tag},
            success: function(oRep){
                ////console.log(oRep);
                $("#userResult").empty();
                for(let i=0; i<oRep.length; i++) {
                    addResult(oRep[i], i, tag);
                    historique.push({"tag": tagClean, "oRep":oRep});
                }
            },
            dataType: "json"
        });
    }
    else {
        //console.log("On cherche dans l'historique")
        let oRep = historique[flag].oRep;
        for(let i=0; i<oRep.length; i++) {
            addResult(oRep[i], i, tag);
            historique.push({"tag":tag, "oRep":oRep});
        }
    }
    
}

$("#userSearch").focusin(function(){
    if(!$("#userSearch").val().length==0) {
        autocomplete();
    }
});

$(document).on("click",".userResult", function(){
    console.log("TEST");
    obj = $(this).data("oRep")
    console.log($(this).data("oRep"));
    $("#inputEmail").val(obj.email);
    $("#inputFirstName").val(obj.prenom);
    $("#inputName").val(obj.nom);
});

$("#userSearch").focusout(function(){
    setTimeout(function(){
        $("#userResult").empty();
    }, 200);
});

$("#userSearch").keydown(function(e){
    //console.log(e.keyCode);
    // échap : 27
    // arrow down : 40
    // arrow up : 38
});

$(".changepass").click(function(){
    $("#changePassDiv").show();
    $(".changepass").hide();
});

$(".validepass").click(function(){
    $("#changePassDiv").hide();
    $(".changepass").show();
    /*
     *
     * Inserer ici le code pour sauvegarder le mot de passe 
     *
     */
})