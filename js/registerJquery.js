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
        alert("Adresse e-mail valide !");
        return;
    } 

    $.ajax({
        type: "POST",
        url: "./minControlleur/dataConnexion.php",
        data: {"email":email,"passe":passe,"checked":check},
        success: function(oRep){
           //console.log(oRep);
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
        alert("Adresse e-mail valide !");
        return;
    } 
   
    /*$.ajax({
        type: "POST",
        url: "./minControlleur/dataConnexion.php",
        data: {"email":email,"passe":passe,"checked":check},
        success: function(oRep){
           //console.log(oRep);
            /*
            gérer ici s'il y a une erreur de connexion, ou si l'utilisateur 
            est connecté
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
    $("#mainInscription").show();
    $("#mainConnexion").hide();
});

/* 
    Si l'on clique sur se connecter, on affiche le formulaire de connexion
*/
$(document).on('click','#signIn',function(){
    console.log("Connexion");
    $("#mainConnexion").show();
    $("#mainInscription").hide();
});