$(document).ready(function(){
    $("#inputEmail3").attr("disabled",true);
    $("#inputFirstName3").attr("disabled",true);
    $("#inputPassword3").attr("disabled",true);
    $("#inputName3").attr("disabled",true);
    $.ajax({
        type: "GET",
        url: "./minControleur/profil.php",
        data: {"action":"getParams"},
        success: function(oRep){
            // oRep[0] == prenom
            // oRep[1] == nom
            // oRep[2] == pass
            // oRep[3] == mail
            $("#inputName3").attr("value",oRep[0]);
            $("#inputFirstName3").attr("value",oRep[1]);
            $("#inputEmail3").attr("value",oRep[2]);
            afficherModif();
        },
    dataType: "json"
    });
})

/**
 * Fonction qui permet d'afficher les boutons permettant la modification des champs
 */
function afficherModif(){
    $(".divForm").append($("<img src='./ressources/edit.png' class='img_profil clic'>").click(function(){
        // lancement d'une fonction de modification !
        modifierChamps(this);
    }));
}

/**
 * Fonction qui permet de passer en mode édition
 * @param {Référence sur le champs de modification} ref 
 */

function modifierChamps(ref){
    console.log(ref);
    var input = $(ref).prev();
    var contenu = $(input).val();
    // on stocke le contenu initial dans le parent
    $(input).parent().data("contenu",contenu);
    $(".divForm img").remove(); // on supprime les anciennes images
    $(input).attr("disabled",false).focus();
    ajoutImgValidation(input);
}

/**
 * Fonction qui permet d'afficher les logos de validation et suppression
 * @param {Référence sur le input} refInput 
 */
function ajoutImgValidation(refInput){
    var refParent = $(refInput).parent();
    $(refParent).append($("<img src='./ressources/addConv.png' class='img_profil clic'>").click(function(){
        // lancement d'une fonction de validation ! Et écrire dans la BDD
        
    }));

    $(refParent).append($("<img src='./ressources/close.png' class='img_profil clic'>").click(function(){
        // lancement d'une fonction de retour en arrière !
        $(refInput).val($(refInput).parent().data("contenu"));
        $(refInput).attr("disabled",true);
        $(".divForm img").remove();
        afficherModif();
    }));
}

/**
 * Lorsque l'on relache une touche en étant focus sur une modification
 * Si on appuie ESCAP on retourne en arrière
 * Si on appuie sur ENTREE on valide
 */
$(document).on("keyup",".divForm input",function(contexte){
    if (contexte.keyCode == 27){ // un appui sur ESCAP 
        $(this).val($(this).parent().data("contenu"));
        $(this).attr("disabled",true);
        $(".divForm img").remove();
        afficherModif();
    }
    
    if (contexte.keyCode == 13){ // un appui sur ENTREE 
        
    } 
})