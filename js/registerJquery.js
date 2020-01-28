$(document).on('click','input[value="Connexion"]',function(){
    console.log("Connexion");
    var login = $("#pseudo").val();
    var passe = $("#inputPassword").val();
    var check = $("#check").prop("checked");
    console.log(login+" + "+passe);
    //console.log(check);
   


    $.ajax({
        type: "POST",
        url: "./minControlleur/dataConnexion.php",
        data: {"login":login,"passe":passe,"checked":check},
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