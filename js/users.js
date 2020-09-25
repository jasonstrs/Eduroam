var historique = [];
var historiqueRole = [];
var changeRole = {};

$("#userSearch").keyup(function(e){
    //console.log(e.keyCode);
    // échap : 27
    // arrow down : 40
    // arrow up : 38
    // entrée : 13
    if(e.keyCode==40) {
        if(!$(".activeResult").length) $(".userResult").eq(0).addClass("activeResult");
        else {
            let index;
            $(".userResult").each(function(i) {
                if($(this).hasClass("activeResult")) {
                    index=i;
                }
            });
            //console.log(index);
            if(index==parseInt($(".userResult").length-1)) {
                $(".userResult").eq(0).addClass("activeResult");
            } else {
                $(".userResult").eq(index+1).addClass("activeResult");
            }
            $(".userResult").eq(index).removeClass("activeResult");
        }
    }
    else if(e.keyCode==38) {
        if(!$(".activeResult").length) $(".userResult").eq(parseInt($(".userResult").length-1)).addClass("activeResult");
        else {
            let index;
            $(".userResult").each(function(i) {
                if($(this).hasClass("activeResult")) {
                    index=i;
                }
            });
            //console.log(index);
            if(index==0) {
                $(".userResult").eq(parseInt($(".userResult").length-1)).addClass("activeResult");
            } else {
                $(".userResult").eq(index-1).addClass("activeResult");
            }
            $(".userResult").eq(index).removeClass("activeResult");
        }
    }
    else if(e.keyCode==27) $(this).blur();
    else if(e.keyCode==13) {
        if($(".userResult").length==1) {
            $(".userResult").click();
            $(this).blur();
        }
        else {
            $(".activeResult").click();
            $(this).blur();
        }
    }
    else if(!$("#userSearch").val().length==0) {
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
    //console.log(tag);
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
                //console.log(oRep);
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
        //console.log(oRep);
        $("#userResult").empty();
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
    changeRole = {};
    $("#userSearch").val($(this).text());
    obj = $(this).data("oRep")
    console.log($(this).data("oRep"));
    $("#inputEmail").val(obj.email);
    $("#inputFirstName").val(obj.prenom);
    $("#inputName").val(obj.nom);
    $("#idUserInput").val(obj.idU);
    if(obj.superadmin==1) $("#switchAdmin").prop("checked", true)
    else $("#switchAdmin").prop("checked", false)
    if(obj.banni==1) {
        console.log("L'user est banni");
        $("#banUser").hide();
        $("#unbanUser").show();

    }
    else {
        $("#banUser").show();
        $("#unbanUser").hide();
    }

    if($("#upToDate").val()==0) {
        //console.log("On charge les rôles")
        $.ajax({
            type: "POST",
            url: "./minControleur/dataUsers.php",
            data: {"action": "getRoles",},
            success: function(oRep){
                //console.log(oRep);
                dispRole(oRep);
                selectRole();
                $("#dispUser").show();
            },
            dataType: "json"
        });
    }
    else {
        selectRole();
        $("#dispUser").show();
    }
});

function dispRole(obj) {
    $("#roleLeft").empty();
    $("#roleRight").empty();
    for(let i=0; i<obj.length; i++) {
        let div = `<div class="offset-sm-2 custom-control custom-switch">
        <input type="checkbox" class="custom-control-input switchRole" id="switchRole`+ obj[i].idRole +`">
        <label class="custom-control-label" for="switchRole`+ obj[i].idRole +`">`+ obj[i].nom +`</label>
    </div>`;
    if(i%2==0) $("#roleLeft").append(div);
    else $("#roleRight").append(div);
    }
}

function selectRole() {
    //console.log(historiqueRole);
    $(".switchRole").prop("checked", false);
    //Ici on récupère les rôles de l'user, et on le met dans l'historique
    let flag=-1;
    let userRole = [];
    let user=$("#idUserInput").val();
    for(let j=0; j<historiqueRole.length; j++) {
        //console.log(tagClean+" = "+historique[j].tag+" ?");
        if(user==historiqueRole[j].user) {
            //console.log("true");
            flag=j;
            break;
        }
    }
    if(flag==-1) {
        console.log("On va chercher les rôles dans la bdd");
        $.ajax({
            type: "POST",
            url: "./minControleur/dataUsers.php",
            data: {"action": "getRolesByUser", "idU":user},
            success: function(oRep){
                //console.log(oRep);
                userRole=oRep;
                historiqueRole.push({"user": user, "oRep":oRep})
                for(let i=0; i<userRole.length; i++) {
                    $("#switchRole"+userRole[i].idRole).prop("checked", true);
                }
            },
            dataType: "json"
        });
    }
    else {
        console.log("On va chercher l'historique");
        userRole=historiqueRole[flag].oRep;
        for(let i=0; i<userRole.length; i++) {
            $("#switchRole"+userRole[i].idRole).prop("checked", true);
        }
    }
}

$(document).on("mouseover",".userResult", function(){
    $(".activeResult").removeClass("activeResult");
    $(this).addClass("activeResult");
});

$("#userSearch").focusout(function(){
    setTimeout(function(){
        $("#userResult").empty();
    }, 200);
});

$(".changepass").click(function(){
    let toggle = $("#changepass").val()==1 ? 0 : 1;
    $("#changepass").val(toggle);
    if(toggle==1) {
        $("#changePassDiv").show();
        $(".changepass").show();
        $(this).hide();
    }
    else {
        $("#changePassDiv").hide();
        $(".changepass").show();
        $(this).hide();
    }
});

$(document).on("change", ".switchRole", function() {
    let id = $(this).attr("id").substr("switchRole".length);
    let val = $(this).prop("checked") ? 1 : -1;
    changeRole[id] = val;
    //console.log(changeRole);
});

$("#inputEmail").change(function(){
    $("#inputEmail").removeClass('is-invalid');
    $("#verifMail").hide();
})

$("#inputPassword").change(function(){
    $("#inputPassword").removeClass('is-invalid');
    $("#verifPasse").hide();
})

$("#saveUser").click(function(){
    let flag=1;
    if(!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test($("#inputEmail").val()))) {
        flag=0;
        $("#verifMail").show();
        $("#verifMail").html("Veuillez saisir une adresse mail correcte.");
        $("#inputEmail").addClass("is-invalid"); // l'adresse mail est invalide

    }
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$&+,:;=?@#|'<>.\-\^\*()%!])[A-Za-z\d$&+,\-:;=?@#|'<>.\^\*()%!]{8,}$/.test($("#inputPassword").val())) && $("#changepass").val()==1) {
        flag=0;
        $("#verifPasse").show();
        $('#verifPasse').html('Veuillez saisir un mot de passe valide (8 caractères minimum dont 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial)');
        $("#inputPassword").addClass('is-invalid');
    }
    if(flag==1) {
        $.ajax({
        type: "POST",
        url: "./minControleur/dataUsers.php",
        data: {"action": "save", "idU":$("#idUserInput").val(), "email":$("#inputEmail").val(), "prenom":$("#inputFirstName").val(), "nom":$("#inputName").val(),
            "changePass":$("#changepass").val(), "password":$("#inputPassword").val(), "admin":$("#switchAdmin").prop("checked"), "role": changeRole},
        success: function(oRep){
            oRep = JSON.parse(oRep);
            if(oRep.success){
                $("#dispUser").hide();
                $("#userSearch").val("");
                addAlert("L'utilisateur a été modifié avec succès");
            }
            else{
                addAlertError(oRep.msg);
            }
            
        },
        dataType: "text"
    });
    historique = [];
    historiqueRole = [];
}
});

$("#banUser").click(function(){
    $.ajax({
        type: "POST",
        url: "./minControleur/dataUsers.php",
        data: {"action": "ban", "idU":$("#idUserInput").val()},
        success: function(oRep){
            $("#dispUser").hide();
            $("#userSearch").val("");
            addAlert("L'utilisateur a été banni avec succès");
        },
        dataType: "text"
    });
    historique = [];
    historiqueRole = [];
});

$("#unbanUser").click(function(){
    $.ajax({
        type: "POST",
        url: "./minControleur/dataUsers.php",
        data: {"action": "unban", "idU":$("#idUserInput").val()},
        success: function(oRep){
            $("#dispUser").hide();
            $("#userSearch").val("");
            addAlert("L'utilisateur a été débanni avec succès");
        },
        dataType: "text"
    });
    historique = [];
    historiqueRole = [];
});

function addAlert(msg) {
    $(".alert").remove();
    $("#containerUser").prepend("<div class='center alert alert-success alert-dismissible fade show' role='alert'>"+msg+".<button type=\"button\" " + 
    "class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
    setTimeout(function(){
        $(".alert").fadeOut(500);
    },5000)
}

function addAlertError(msg) {
    $(".alert").remove();
    $("#containerUser").prepend("<div class='center alert alert-danger alert-dismissible fade show' role='alert'>"+msg+".<button type=\"button\" " + 
    "class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
    setTimeout(function(){
        $(".alert").fadeOut(500);
    },5000)
}