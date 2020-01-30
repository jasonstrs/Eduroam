$(document).ready(function(){
    $("#mainInscription").hide();
    $("verifMail").hide();
    $("verifMailInscription").hide();
})

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

    

    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email))) {
        $("verifMailInscription").show();
        $("#verifMailInscription").append("Veuillez saisir une adresse mail correcte.");
        return;
    } 

    // on regarde si les mots de passe sont différents
    if (confirm != passe){

    }
   
    /*$.ajax({
        type: "POST",
        url: "./minControlleur/dataInscription.php",
        data: {"email":email,"passe":passe,"nom":nom,"prenom":prenom},
        success: function(oRep){
           //console.log(oRep);
            /*
            
            */
      //  },
    //dataType: "text"
    //});
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
    $("#verifMail").hide();
    $("#mainConnexion").show();
    $("#mainInscription").hide();
});