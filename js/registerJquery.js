$(document).ready(function(){
    $("#mainInscription").hide();
})

// Connexion
$(document).on('click','input[value="Connexion"]',function(){
    console.log("Connexion");
    var email = $("#email").val();
    var passe = $("#inputPassword").val();
    var check = $("#check").prop("checked");
    console.log(email+" + "+passe);
    
    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email))) {
        $("#containerMail").append("<div class='text-danger dangerMail'>Veuillez saisir une adresse mail correcte.</div>");
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

    console.log(email+" + "+passe+" + "+nom+" + "+prenom);
    // on verifie que l'adresse mail n'est pas incorrecte
    if (!(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email))) {
        $("#containerMailInscription").append("<div class='text-danger dangerMail'>Veuillez saisir une adresse mail correcte.</div>");

        return;
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
    $(".dangerMail").remove();
    $("#mainInscription").show();
    $("#mainConnexion").hide();
});

/* 
    Si l'on clique sur se connecter, on affiche le formulaire de connexion
*/
$(document).on('click','#signIn',function(){
    console.log("Connexion");
    $(".dangerMail").remove();
    $("#mainConnexion").show();
    $("#mainInscription").hide();
});