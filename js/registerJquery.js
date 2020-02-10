$(document).ready(function(){
    $("#mainInscription").hide();
    cacherMsg();
})

// Cacher les messages d'erreurs
function cacherMsg(){
    $("#log").hide();
    $("#envoiMail").hide();
    $("#verifMail").hide();
    $("#verifMailInscription").hide();
    $("#verifNomInscription").hide();
    $("#verifPrenomInscription").hide();
    $("#verifPasswordInscription").hide();
    $("#verifPasswordConfirmInscription").hide();
    $("#keyPass").hide();
    $("#checkPass").hide();
    $("#verifForgetPass").hide();
    $("#verifMailReceive").hide();
    $("#haveMail").hide();
}

// Connexion
$(document).on('click','input[value="Connexion"]',function(){
    console.log("Connexion");
    cacherMsg();
    var email = $("#email").val();
    var passe = $("#inputPassword").val();
    var check = $("#check").prop("checked");
    
    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
        $("#verifMail").show();
        $("#verifMail").html("Veuillez saisir une adresse mail correcte.");
        return;
    }

    
    if (passe == ""){
        $("#checkPass").show();
        $("#checkPass").html("Veuillez saisir un mot de passe.");
        return;
    }


    if (check)
        check = "remember";
    else
        check='noRemember';
        
    $.ajax({
        type: "POST",
        url: "./minControleur/dataConnexion.php",
        data: {"email":email,"passe":passe,"checked":check,"action":'Connexion'},
        success: function(oRep){
           console.log(oRep);
           switch(oRep){
               case 'incorrect' :
                   $("#log").show();
                   $("#log").html("Email et/ou mot de passe incorrect");
                break;

                case 'noConfirm' :
                   $("#log").show();
                   $("#log").html("Veuillez confirmer votre email avant de vous connecter. ");
                   $("#log").append($("<span class='newMail clic'>Recevoir un mail de confirmation ?</span>").click(function(){
                       console.log("envoyer un mail pour recevoir une nouvelle confirmation");
                       sendMailConfirm();
                   }));
                break;

                case 'success' :
                   console.log("cas3");
                   //////// envoyer vers la page d'accueil !
                break;

                default:
                    console.log("Il y a un problème inconnu ! Contacter la maintenance.");
           }
            
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

    if (verificationChamps()){ // petite sécurité
        $.ajax({
            type: "POST",
            url: "./minControleur/dataConnexion.php",
            data: {"email":email,"passe":passe,"nom":nom,"prenom":prenom,"action":'Inscription'},
            success: function(oRep){
    
                if (oRep == 'Success'){
                    $("#mainInscription").hide();
                    $("#mainConnexion").hide();
                    $("#envoiMail").show();
                    $("#envoiMail").html("<h4 class=\"alert-heading\">Inscription terminée</h4><p>Un email vient de vous être envoyé. Veuillez confirmer votre adresse mail avant de pouvoir vous connecter !</p>");
                } else if (oRep == 'Exist'){
                    $("#verifMailInscription").show();
                    $("#verifMailInscription").html("Adresse mail déjà existante.");
                }
            },
        dataType: "text"
        });
    }
});


/*
    Si l'on clique sur mot de passe oublié
*/

$(document).on("click",'#forgotPass',function(){
    console.log("mot de passe oublie");
    cacherMsg();
    $("#mainInscription").hide();
    $("#mainConnexion").hide();
    $("#keyPass").show();
});

$(document).on("click","#receive",function(){
    console.log("receive");
    // on verifie que l'adresse mail n'est pas incorrecte
    var email = $("#emailRecup").val();
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
        $("#verifForgetPass").show();
        $("#verifForgetPass").html("Veuillez saisir une adresse mail correcte.");
        return;
    }
    // on envoie une reqûete ajax dans un minControleur
    // on regarde si l'adresse existe, si oui, on envoie un mail
    // si l'adresse saisie est correcte, vous allez recevoir un mail pour modifier votre mdp
    $.ajax({
        type: "POST",
        url: "./minControleur/dataConnexion.php",
        data: {"email":email,"action":"PassWord"},
        success: function(oRep){
            switch(oRep){
                case 'success' :
                    $("#keyPass").hide();
                    $("#envoiMail").show();
                    $("#envoiMail").html("<h4 class=\"alert-heading\">Mail envoyé !</h4><p>Un email vient d'être envoyé à l'adresse <b>" + email +"</b>. Veuillez suivre les instructions afin de modifier votre mot de passe !</p>");
                 break;
 
                 case 'incorrect' :
                    $("#verifForgetPass").show();
                    $("#verifForgetPass").html("Adresse mail inexistante.");
                 break;
 
                 default:
                     console.log("Il y a un problème inconnu ! Contacter la maintenance.");
            }
        },
    dataType: "text"
    });

    
});

/**
 * Envoi un nouveau mail de confirmation
 */

 function sendMailConfirm(){
    cacherMsg();
    $("#mainInscription").hide();
    $("#mainConnexion").hide();
    $("#haveMail").show();
 }

    /**
     * recevoir un nouveau mail
     */

    $(document).on("click","#receiveMail",function(){
        console.log('new mail');
        // on verifie que l'adresse mail n'est pas incorrecte
        var email = $("#emailReceive").val();
        if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
            console.log('new mail2');
            $("#verifMailReceive").show();
            $("#verifMailReceive").html("Veuillez saisir une adresse mail correcte.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "./minControleur/dataConnexion.php",
            data: {"email":email,"action":"NewMail"},
            success: function(oRep){
                switch(oRep){
                    case 'success' :
                        $("#haveMail").hide();
                        $("#envoiMail").show();
                        $("#envoiMail").html("<h4 class=\"alert-heading\">Mail envoyé !</h4><p>Un email vient d'être envoyé à l'adresse <b>" + email +"</b>. Veuillez suivre les instructions afin de confirmer votre mail !</p>");
                     break;
     
                     case 'confirm' :
                        $("#verifMailReceive").show();
                        $("#verifMailReceive").html("Adresse mail déjà confirmée. ")
                        $("#verifMailReceive").append($("<span class='newMail clic'>Revenir à la page de connexion ?<span>").click(function(){
                            cacherMsg();
                            $("#mainConnexion").show();
                            $("#mainInscription").hide();
                        }));
                     break;
     
                     case 'incorrect' :
                        $("#verifMailReceive").show();
                        $("#verifMailReceive").html("Adresse mail inexistante.");
                     break;
     
                     default:
                         console.log("Il y a un problème inconnu ! Contacter la maintenance.");
                }
            },
        dataType: "text"
        });
        

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
    return 1;
}

function verifNom(){
    var nom = $("#nom").val();
    if(!(/^[a-zâäàéèùêëîïôöçñ \-]+$/i.test(nom)) && nom!=""){
        $("#verifNomInscription").show();
        $("#verifNomInscription").html("Veuillez saisir un nom correct.");
        return 0;
    }
    $("#verifNomInscription").hide(); // Si l'utilisateur a corrigé son erreur, le msg disparait
    return 1;
}

function verifPrenom(){
    var prenom = $("#prenom").val();
    if(!(/^[a-zâäàéèùêëîïôöçñ \-]+$/i.test(prenom)) && prenom !=""){
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
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
        $("verifMailInscription").show();
        $("#verifMailInscription").html("Veuillez saisir une adresse mail correcte.");
        return 0;
    }
    $("verifMailInscription").hide();
    return 1; 
}


function verifPasse(){
    var passe = $("#inputPasswordInscription").val();
    if (passe == "")
        return 0;
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