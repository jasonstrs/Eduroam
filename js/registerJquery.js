$(document).ready(function(){
    cacherMsg();
})


// form Inscription
function formInscription(){
    var form = "<div id='mainInscription'>"+
    '<div class="page-header">'+
      '<h1 class="text-center">Inscription</h1>'+
    '</div>'+
    '<div class="jumbotron" id="blocInscription">'+
        '<div class="form-group row">'+
            '<label for="nom" class="col-sm-2 col-form-label">Nom</label>'+
            '<div class="col-sm-10">'+
            '<input type="text" class="form-control" id="nom" placeholder="Saisir votre nom">'+
            "<div id='verifNomInscription' class='text-danger'></div>"+
          '</div>'+
        '</div>'+
        '<div class="form-group row">'+
            '<label for="prenom" class="col-sm-2 col-form-label">Prénom</label>'+
            '<div class="col-sm-10">'+
            '<input type="text" class="form-control" id="prenom" placeholder="Saisir votre prenom">'+
            "<div id='verifPrenomInscription' class='text-danger'></div>"+
            '</div>'+
        '</div>'+
        '<div class="form-group row">'+
            '<label for="email" class="col-sm-2 col-form-label">Email</label>'+
            '<div class="col-sm-10" id="containerMailInscription">'+
              '<input type="email" class="form-control" id="emailInscription" placeholder="Saisir votre email">'+
              "<div id='verifMailInscription' class='text-danger'></div>"+
            '</div>'+
        '</div>'+
        '<div class="form-group row">'+
          '<label for="inputPasswordInscription" class="col-sm-2 col-form-label">Mot de passe</label>'+
          '<div class="col-sm-10">'+
            '<input type="password" class="form-control" id="inputPasswordInscription" placeholder="Saisir votre mot de passe">'+
            "<div id='verifPasswordInscription' class='text-danger'></div>"+
          '</div>'+
        '</div>'+

        '<div class="form-group row">'+
          '<label for="inputPasswordConfirm" class="col-sm-2 col-form-label">Confirmation</label>'+
          '<div class="col-sm-10">'+
            '<input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Confirmer votre mot de passe">'+
            "<div id='verifPasswordConfirmInscription' class='text-danger'></div>"+
          '</div>'+
        '</div>'+
        "<div class='submit'>"+
          '<input type="submit" id="inscription" name="action"  value="Inscription" class="btn btn-outline-secondary">'+
        '</div>'+
       "<div class='register'>"+
          "<small id='signIn' class='form-text text-muted clic'>Vous avez déjà un compte ? Connectez-vous ici</small>"+
        "</div>"+
    "</div>"+
  "</div>";

  $("#mainConnexion").hide();
  $("#form").html(form);
  $("#verifMailInscription").hide();
  $("#verifNomInscription").hide();
  $("#verifPrenomInscription").hide();
  $("#verifPasswordInscription").hide();
  $("#verifPasswordConfirmInscription").hide();
}


// MDP oublié
function formMDP(){
    var form = "<div class='form-group row' id='keyPass'>"+
    "<h4>Mot de passe oublié</h4>"+
    '<div class="col-sm-10" id="containerMailInscription">'+
      '<input type="email" class="form-control" name="email" id="emailRecup" placeholder="Saisir votre email">'+
      "<div id='verifForgetPass' class='text-danger'></div>"+
      "<input type='submit' value='Recevoir' id='receive' class='btn btn-outline-secondary'>"+
    '</div>'+
  "</div>";
  $("#mainConnexion").hide();
  $("#form").html(form);
}

// newMail
function formNewMail(){
    var form = "<div class='form-group row' id='haveMail'>"+
    '<h4>Recevoir un nouveau mail</h4>'+
    "<div class='col-sm-10' id='receiveNewMail'>"+
      '<input type="email" class="form-control" name="newM" id="emailReceive" placeholder="Saisir votre email">'+
      "<div id='verifMailReceive' class='text-danger'></div>"+
      "<input type='submit' value='Recevoir un mail' id='receiveMail' class='btn btn-outline-secondary'>"+
    "</div>"+
 "</div>";
 $("#mainConnexion").hide();
 $("#form").html(form);
 $("#verifMailReceive").hide();
}

// Cacher les messages d'erreurs
function cacherMsg(){
    $("#log").hide();
    $("#envoiMail").hide();
    $("#verifMail").hide();
    $("#checkPass").hide();
}

// Connexion
$(document).on('click','input[value="Connexion"]',function(){
    console.log("Connexion");
    cacherMsg();
    var email = $("#email").val();
    var passe = $("#inputPassword").val();
    var check = $("#check").prop("checked");
    
    connexion(email,passe,check);
});


$(document).on("keyup","#email,#inputPassword",function(contexte){
   if (contexte.keyCode == 13){ // appuie sur Entrée
        var email = $("#email").val();
        var passe = $("#inputPassword").val();
        var check = $("#check").prop("checked");
        connexion(email,passe,check);
   } 
});

 //////////////////////////////////////////////////////////////////////////////////////////////

 function connexion(email,passe,check){
    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
        $("#verifMail").show();
        $("#verifMail").html("Veuillez saisir une adresse mail correcte.");
        $("#email").addClass("is-invalid"); // l'adresse mail est invalide
        return;
    }
    $("#email").removeClass("is-invalid"); // on enlvève la classe invalide

    if (passe == ""){
        $("#checkPass").show();
        $("#checkPass").html("Veuillez saisir un mot de passe.");
        $("#inputPassword").addClass('is-invalid');
        return;
    }
    $("#inputPassword").removeClass('is-invalid');
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
                       sendMailConfirm(email);
                   }));
                break;

                case 'success' :
                   console.log("cas3");
                   location.replace("index.php?view=accueil");
                break;

                default:
                    console.log("Il y a un problème inconnu ! Contacter la maintenance.");
           }
            
        },
    dataType: "text"
    });
 }


// Inscription
$(document).on('click','input[value="Inscription"]',function(){
    console.log("Inscription");
    var email = $("#emailInscription").val();
    var passe = $("#inputPasswordInscription").val();
    var nom = $("#nom").val();
    var prenom = $("#prenom").val();

    if (verificationChamps()){ // petite sécurité
        $("#inscription").attr("disabled",true);
        $.ajax({
            type: "POST",
            url: "./minControleur/dataConnexion.php",
            data: {"email":email,"passe":passe,"nom":nom,"prenom":prenom,"action":'Inscription'},
            success: function(oRep){
                console.log(oRep);
                if (oRep == 'Success'){
                    $("#mainInscription").hide();
                    $("#mainConnexion").hide();
                    $("#envoiMail").show();
                    $("#envoiMail").html("<h4 class=\"alert-heading\">Inscription terminée</h4><p>Un email vient de vous être envoyé. Veuillez confirmer votre adresse mail avant de pouvoir vous connecter !</p>");
                } else if (oRep == 'Exist'){
                    $("#inscription").attr("disabled",false);
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
    formMDP();
    $("#emailRecup").attr("value",$("#email").val());
});

$(document).on("click","#receive",function(){
    
    // on verifie que l'adresse mail n'est pas incorrecte
    var email = $("#emailRecup").val();
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
        $("#verifForgetPass").show();
        $("#verifForgetPass").html("Veuillez saisir une adresse mail correcte.");
        $("#emailRecup").addClass("is-invalid");
        return;
    }
    $("#emailRecup").removeClass("is-invalid");

    // on envoie une reqûete ajax dans un minControleur
    // on regarde si l'adresse existe, si oui, on envoie un mail
    // si l'adresse saisie est correcte, vous allez recevoir un mail pour modifier votre mdp
    $("#receive").attr("disabled",true);
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
                    $("#receive").attr("disabled",false);
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

 function sendMailConfirm(email){
    cacherMsg();
    $("#mainInscription").hide();
    $("#mainConnexion").hide();
    $("#haveMail").show();
    $("#emailReceive").attr("value",email);
 }

    /**
     * recevoir un nouveau mail
     */

    $(document).on("click","#receiveMail",function(){
        console.log('new mail');
        // on verifie que l'adresse mail n'est pas incorrecte
        var email = $("#emailReceive").val();
        if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email))) {
            $("#verifMailReceive").show();
            $("#verifMailReceive").html("Veuillez saisir une adresse mail correcte.");
            $("#emailReceive").addClass('is-invalid');
            return;
        }
        $("#emailReceive").removeClass('is-invalid');
        $("#receiveMail").attr("disabled",true);
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
                        $("#receiveMail").attr("disabled",false);
                        $("#verifMailReceive").show();
                        $("#verifMailReceive").html("Adresse mail déjà confirmée. ")
                        $("#verifMailReceive").append($("<span class='newMail clic'>Revenir à la page de connexion ?<span>").click(function(){
                            cacherMsg();
                            $("#mainConnexion").show();
                            $("#mainInscription").hide();
                        }));
                     break;
     
                     case 'incorrect' :
                        $("#receiveMail").attr("disabled",false);
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
    formInscription();
    $("#mainConnexion").hide();
    // On désactive le bouton inscription
    $("#inscription").attr("disabled",true);
});

/* 
    Si l'on clique sur se connecter, on affiche le formulaire de connexion
*/
$(document).on('click','#signIn',function(){
    cacherMsg();
    $("#mainInscription").remove();
    $("#mainConnexion").show();
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
        $("#verifNomInscription").html("Veuillez saisir un nom correct (uniquement des lettres).");
        $("#nom").addClass('is-invalid');
        return 0;
    }
    if (nom !='')
        $("#nom").removeClass('is-invalid').addClass('is-valid');
    else{
        $("#nom").removeClass('is-valid'); // si l'utilisateur met un bon nom et le changer après
        return 0;
    }
    $("#verifNomInscription").hide(); // Si l'utilisateur a corrigé son erreur, le msg disparait
    return 1;
}

function verifPrenom(){
    var prenom = $("#prenom").val();
    if(!(/^[a-zâäàéèùêëîïôöçñ \-]+$/i.test(prenom)) && prenom !=""){
        $("#verifPrenomInscription").show();
        $("#verifPrenomInscription").html("Veuillez saisir un prénom correct (uniquement des lettres).");
        $("#prenom").addClass('is-invalid');
        return 0;
    }
    if (prenom != '')
        $("#prenom").removeClass('is-invalid').addClass('is-valid');
    else{
        $("#prenom").removeClass('is-valid'); // si l'utilisateur met un bon nom et le changer après
        return 0;
    }

    $("#verifPrenomInscription").hide();
    return 1;
}

function verifEmail(){
    var email = $("#emailInscription").val();
    // on verifie que l'adresse mail n'est pas incorrecte

    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/i.test(email)) && email != '' ) {
        $("#verifMailInscription").show();
        $("#verifMailInscription").html("Veuillez saisir une adresse mail correcte.");
        $("#emailInscription").addClass('is-invalid');
        return 0;
    }

    if (email != ''){
        $("#emailInscription").addClass('is-valid').removeClass('is-invalid');
    } else {
        $("#verifMailInscription").hide();
        $("#emailInscription").removeClass('is-valid is-invalid'); // si l'utilisateur met un bon mail et le change après
        return 0;
    }
    $("#verifMailInscription").hide();
    return 1; 
}


function verifPasse(){
    var passe = $("#inputPasswordInscription").val();
    if (passe == ""){
        $("#inputPasswordInscription").removeClass('is-invalid is-valid');
        $("#verifPasswordInscription").hide();
        return 0;
    }
        
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/.test(passe))){
        $("#verifPasswordInscription").show();
        $('#verifPasswordInscription').html('Veuillez saisir un mot de passe valide (8 caractères minimum dont 1 majuscule, 1 minuscule et 1 chiffre)');
        $("#inputPasswordInscription").addClass('is-invalid');
        return 0;
    }
    $("#inputPasswordInscription").addClass('is-valid').removeClass('is-invalid');
    $("#verifPasswordInscription").hide();
    return 1;
}

function verifConfirmationPasse(){
    var passe = $("#inputPasswordInscription").val();
    var confirmMDP =$("#inputPasswordConfirm").val();

    if (confirmMDP == ""){
        $("#inputPasswordConfirm").removeClass('is-invalid is-valid');
        $("#verifPasswordConfirmInscription").hide();
        return 0;
    }
    

    if (passe != confirmMDP){
        $("#verifPasswordConfirmInscription").show();
        $("#verifPasswordConfirmInscription").html("Veuillez saisir un mot de passe identique.");
        $("#inputPasswordConfirm").addClass('is-invalid');
        return 0;
    }
    $("#inputPasswordConfirm").addClass('is-valid').removeClass('is-invalid');
    $("#verifPasswordConfirmInscription").hide();
    return 1;
}