$(document).ready(function(){
    $("#mainInscription").hide();
    cacherMsg();
})

// Cacher les messages d'erreurs
function cacherMsg(){
    $("#envoiMail").hide();
    $("#verifMail").hide();
    $("#verifMailInscription").hide();
    $("#verifNomInscription").hide();
    $("#verifPrenomInscription").hide();
    $("#verifPasswordInscription").hide();
    $("#verifPasswordConfirmInscription").hide();

}

// Connexion
$(document).on('click','input[value="Connexion"]',function(){
    console.log("Connexion");
    var email = $("#email").val();
    var passe = $("#inputPassword").val();
    var check = $("#check").prop("checked");
    
    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email))) {
        $("verifMail").show();
        $("#verifMail").append("Veuillez saisir une adresse mail correcte.");
        return;
    } 

    $.ajax({
        type: "POST",
        url: "./minControlleur/dataConnexion.php",
        data: {"email":email,"passe":passe,"checked":check},
        success: function(oRep){
           console.log(oRep);
            /*
            gérer ici s'il y a une erreur de connexion, ou si l'utilisateur 
            est connecté
            */
        },
    dataType: "text"
    });
});

// Inscription
$(document).on('click','input[value="Inscription"]',function(){
    console.log("Inscription");
    var email = $("#emailInscription").val();
    var passe = $("#inputPasswordInscription").val();
    var nom = $("#nom").val();
    var prenom = $("#prenom").val();
    var confirMDP =$("#inputPasswordConfirm").val(); 


    /*$.ajax({
        type: "POST",
        url: "./minControlleur/dataInscription.php",
        data: {"email":email,"passe":passe,"nom":nom,"prenom":prenom},
        success: function(oRep){*/
           
            //if (SUCCES){
                // renvoyer l'utilisateur sur la page de connexion avec un popup 'Un email vous a été envoyé, veuillez confirmer votre adresse mail'
                //$("#mainInscription").hide();
                //$("#mainConnexion").hide();
                // $("#envoiMail").show();
            //}
      /*  },
    //dataType: "text"
    //});*/
});
/*
    Si l'on clique sur mot de passe oublié
*/

$(document).on("click",'#forgotPass',function(){
    console.log("mot de passe oublie");
    
});

/* 
    Si l'on clique sur créer un compte, on affiche le formulaire d'inscription
*/
$(document).on('click','#signUp',function(){
    console.log("Se créer un compte");
    $("#verifMailInscription").hide();
    $("#mainInscription").show();
    $("#mainConnexion").hide();
    // On désactive le bouton inscription
    $("#inscription").attr("disabled",true);
});

/* 
    Si l'on clique sur se connecter, on affiche le formulaire de connexion
*/
$(document).on('click','#signIn',function(){
    console.log("Connexion");
    cacherMsg();
    $("#mainConnexion").show();
    $("#mainInscription").hide();
});

// on vérifie si les champs sont bien remplis
$(document).on('keyup','#blocInscription :input',function(){
    verificationChamps();
});

///////////////////////////////////////////////
function verificationChamps(){
    var flag=1;
    
    flag = verifNom() && flag;
    flag = verifPrenom() && flag;
    flag = verifEmail() && flag;
    flag = verifPasse() && flag;
    flag = verifConfirmationPasse() && flag;

    if (flag == 1){
        // On réactive le bouton inscription
         $("#inscription").attr("disabled",false);
    }
}

function verifNom(){
    var nom = $("#nom").val();
    if(!(/^[a-zA-Z -]+$/.test(nom)) && nom!=""){
        $("#verifNomInscription").show();
        $("#verifNomInscription").html("Veuillez saisir un nom correct.");
        return 0;
    }
    $("#verifNomInscription").hide(); // Si l'utilisateur a corrigé son erreur, le msg disparait
    return 1;
}

function verifPrenom(){
    var prenom = $("#prenom").val();
    if(!(/^[a-zA-Z -]+$/.test(prenom)) && prenom !=""){
        $("#verifPrenomInscription").show();
        $("#verifPrenomInscription").html("Veuillez saisir un prénom correct.");
        return 0;
    }
    $("#verifPrenomInscription").hide();
    return 1;
}

function verifEmail(){
    var email = $("#emailInscription").val();
    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email))) {
        $("verifMailInscription").show();
        $("#verifMailInscription").html("Veuillez saisir une adresse mail correcte.");
        return 0;
    }
    $("verifMailInscription").hide();
    return 1; 
}


function verifPasse(){
    var passe = $("#inputPasswordInscription").val();
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/.test(passe))){
        $("#verifPasswordInscription").show();
        $('#verifPasswordInscription').html('Veuillez saisir un mot de passe valide (8 caractères minimum dont 1 majuscule, 1 minuscule et 1 chiffre)');
        return 0;
    }
    $("#verifPasswordInscription").hide();
    return 1;
}

function verifConfirmationPasse(){
    var passe = $("#inputPasswordInscription").val();
    var confirmMDP =$("#inputPasswordConfirm").val();
    if (confirmMDP == "")
        return 0;

    if (passe != confirmMDP){
        $("#verifPasswordConfirmInscription").show();
        $("#verifPasswordConfirmInscription").html("Veuillez saisir un mot de passe identique.");
        return 0;
    }
    $("#verifPasswordConfirmInscription").hide();
    return 1;
}