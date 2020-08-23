var aideNbJours = $("<span/>").append($("<i/>").attr("id","aideNbJours").addClass("fas fa-question-circle pointer").css({"font-size":"1.5rem","margin-left":"10px","color":"rgb(0, 132, 255)"})).click(function(){
    contenuModal = "Pour éviter que vous ne receviez trop de mails concernant les spectacles, vous pouvez choisir le nombre de jours minimum entre 2 notifications par mail.";
    contenuModal += "<br><br>Le minimum est 1 jour, le maximum est 14 jours. ";
    contenuModal += "<br><br>Si vous ne souhaitez plus recevoir de mails concernant les spectacles, décochez la case ci-dessous.";

    

    creerModal("modalNbJours","Réduction des envois de mails",contenuModal,"Compris !","btn btn-outline-primary none",{});
    $("#modalNbJours").modal();
    return false;
});

var validerNbJours = $("<span/>").append($("<i/>").attr("id","validerNbJours").addClass("fas fa-check-circle pointer").css({"font-size":"1.5rem","margin-left":"10px","color":"green"})).click(function(){
    $(".alert").remove();
    $("#validerNbJours").replaceWith(aideNbJours.clone(1));

    var nb = $("#choisirNbJours").val();
    var idU = sessionStorage.getItem("idU");

    $.ajax({
        type: "POST",
        url: "./minControleur/dataProfil.php",
        data: {
            "action":"modifNbJoursMail",
            "nb":nb,
            "idU":idU
        },
        success: function(oRep){
            console.log(oRep);
            var rep = oRep;
            if(rep.success == "0"){
                $("#nbJoursMail").append(alerteB.clone(1).addClass("alert-danger alert-block").html("Erreur lors de la modification").append(boutonFermerAlerteB.clone(1)));
            }
            else{
                $("#nbJoursMail").append(alerteB.clone(1).addClass("alert-success alert-block").html("Modification réussie ! ").append(boutonFermerAlerteB.clone(1)));
            }
        },
        dataType: "json"
    });

    return false;
});

$(document).ready(function(){
    $("#inputEmail").attr("disabled",true);
    $("#inputFirstName").attr("disabled",true);
    $("#modifierPass").attr("disabled",true);
    $("#inputName").attr("disabled",true);
    
    $.ajax({
        type: "GET",
        url: "./minControleur/dataProfil.php",
        data: {"action":"getParams"},
        success: function(oRep){
            // oRep[0] == prenom
            // oRep[1] == nom
            // oRep[2] == mail
            // oRep[3] == choice
            $("#inputFirstName").attr("value",oRep[0]);
            $("#inputName").attr("value",oRep[1]);
            $("#inputEmail").attr("value",oRep[2]);
            afficherModif();
            
            var ch=''; // permet de savoir si on doit cocher ou non le switch
            if (oRep[3] == 1)
                ch='checked';

            afficherNotif(ch);
        },
    dataType: "json"
    });

    $("#choisirNbJours").change(function(){
        $("#aideNbJours").replaceWith(
            $(validerNbJours.clone(1))
        );        
    });
})

function afficherNotif(choice){
    // LANCER UNE REQUETE AJAX QUI REGARDE SI c'EST COCHE ou NON DANS LA BDD

    var notif = '<div class="custom-control custom-switch">'+
                    '<input type="checkbox" class="custom-control-input" id="switch" '+choice + ' >'+
                    '<label class="custom-control-label" for="switch">Recevoir les notifications par email</label>'+
                '</div>';
    $("#mainProfil").append(notif);
}

/**
 * Fonction qui permet d'afficher les boutons permettant la modification des champs
 */
function afficherModif(){
    $(".divForm").append($("<img src='./ressources/icons/pencil.svg' class='img_profil clic'>").click(function(){
        // lancement d'une fonction de modification !
        modifierChamps(this);
    }));
    $("#aideNbJours").remove();
    $("#nbJoursMail>.col-sm-10").append(aideNbJours.clone(1));
}

/**
 * Fonction qui permet de passer en mode édition
 * @param {Obj} ref Référence sur le champ de modification
 */

function modifierChamps(ref){
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
    $(refParent).append($("<img src='./ressources/icons/check.svg' class='img_profil clic'>").click(function(){
        // lancement d'une fonction de validation ! Et écrire dans la BDD
        validationChangement(refInput);
    }));

    $(refParent).append($("<img src='./ressources/icons/x.svg' class='img_profil clic'>").click(function(){
        // lancement d'une fonction de retour en arrière !
        retourArriere(refInput);
    }));
}

/**
 * Lorsque l'on relache une touche en étant focus sur une modification
 * Si on appuie sur ENTREE on valide avec focus
 */
$(document).on("keyup",".divForm input",function(contexte){
    if (contexte.keyCode == 13){ // un appui sur ENTREE 
        validationChangement(this);
    } 
})

/**
 * Lorsque l'on relache une touche en étant focus sur une modification
 * Si on appuie sur ESCAP on réinitialise le tout
 * Pas de sélecteur car le ESCAP se fait sur toute la page
 */
$(document).on("keyup",function(contexte){
    
    if (contexte.keyCode == 27){ // un appui sur ESCAP 
        $(".divForm input").each(function(){
            if (!($(this).attr("disabled"))) // si le champs est pas disabled
                retourArriere(this); // c'est le champs qui est modifié
        });
    }
})

/**
 * Fonction qui permet de revenir au contenu initial
 * @param {Référence sur le input} refInput 
 */
var retourArriere = function retourArriere(refInput){
    $("#checkPass").remove();
    $("#checkName").remove();
    $("#checkFirstName").remove();
    $(refInput).val($(refInput).parent().data("contenu"));
    $(refInput).attr("disabled",true);
    $(".divForm img").remove();
    afficherModif();
}

/**
 * Vérifie si les champs entrés sont corrects
 * @param {Référence sur le input} refInput 
 */
function validationChangement(refInput){
    $(refInput).attr("disabled",true);
    var contenu = $(refInput).val();
    var flag=0;
    var action="";
    if ($(refInput).is("#modifierPass")){ // on effectue la verification MOT DE PASSE
        flag = verificationPassWord(contenu,refInput);
        action="mot de passe";
    }
    else if ($(refInput).is("#inputName")){  // on effectue la verification NOM
        flag = verificationNom(contenu,refInput);
        action="nom";
    }
    else { // on effectue la verification PRENOM
        flag = verificationPrenom(contenu,refInput);
        action="prénom";
    }

    if (flag) // le champ entré est un succès !
        if (action == "mot de passe"){
            // on lance un modal pour confirmer le MDP
            // On crée la fonction de vérification
            var test = function(refInput){
                
                if ($("#modifierPass").val() == $(refInput).val()){ // si deux mots de passe identiques
                    // CHGMT BDD
                    modificationBDD(action,contenu);
                    return 1;
                }
                else {
                    $("#checkVerifPass").remove(); // si la vérification existe déjà
                    $(refInput).parent().prepend("<div id='checkVerifPass' class='text-danger center'></div>")
                    $('#checkVerifPass').html('Veuillez saisir un mot de passe identique');
                    return 0;
                }
            }
            creerModalVerif("passWd","Confirmer votre mot de passe","Modifier","btn-outline-secondary","password","Saisir mot de passe",
            test,function(){retourArriere($("#modifierPass"))}
            ,1);
            $("#passWd").modal();

        } else // sinon on lance directement la modif en BDD
            modificationBDD(action,contenu);
    else // l'utilisateur doit faire des modifications correctes
        $(refInput).attr("disabled",false); 
}

function modificationBDD(action,contenu){
    console.log("modification BDD");
    $(".divForm img").remove();
    afficherModif();

    $.ajax({
        type: "POST",
        url: "./minControleur/dataProfil.php",
        data: {"action":action,"contenu":contenu},
        success: function(oRep){
            console.log(oRep);
            $(".alert").remove(); // on supprime les anciennes alertes ! pour éviter le spam sur l'écran
            if (oRep == "Success"){ // le changement a eu lieu
                $(".container").prepend("<div class='center alert alert-success alert-dismissible fade show' role='alert'>Votre <strong>"
                +action+"</strong> a été modifié avec succès.<button type=\"button\" " + 
                "class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
            } else { // ERREUR
                $(".container").prepend("<div class='center alert alert-danger alert-dismissible fade show' role='alert'>Votre <strong>"
                +action+"</strong> n'a pas pu être modifié.<button type=\"button\" " + 
                "class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
                switch(action) { // on remet l'ancien contenu
                    case 'prénom' :
                        $("#inputFirstName").val($("#inputFirstName").parent().data("contenu"));
                    break;
                    case 'nom' :
                        $("#inputName").val($("#inputName").parent().data("contenu"));
                    break;
                    case 'mot de passe' :
                        $("#inputPassword").val($("#inputPassword").parent().data("contenu"));
                    break;
                    default :
                        console.log('Veuillez contacter la maintenance');
                }
            }
        },
    dataType: "text"
    });
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Vérification si le mot de passe est correct
 * @param {Contenu du input} contenu 
 */
function verificationPassWord(contenu,refInput){
    $("#checkPass").remove();
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$&+,:;=?@#|'<>.\-\^\*()%!])[A-Za-z\d$&+,\-:;=?@#|'<>.\^\*()%!]{8,}$/.test(contenu)) || contenu == ""){
        $(refInput).parent().append("<div id='checkPass' class='text-danger'></div>");
        $('#checkPass').html('Veuillez saisir un mot de passe valide (8 caractères minimum dont 1 majuscule, 1 minuscule, 1 chiffre et un caractère spécial)');
        return 0;
    }
    return 1;
}

/**
 * Vérification si le nom est correct
 * @param {Contenu du input} contenu 
 */
function verificationNom(contenu,refInput){
    $("#checkFirstName").remove();
    if(!(/^[a-zâäàéèùêëîïôöçñ \-]+$/i.test(contenu)) && contenu !=""){
        $(refInput).parent().append("<div id='checkFirstName' class='text-danger'></div>");
        $("#checkFirstName").html("Veuillez saisir un nom correct (uniquement des lettres et non vide).");
        return 0;
    }
    return 1;
}

/**
 * Vérification si le prenom est correct
 * @param {Contenu du input} contenu 
 */
function verificationPrenom(contenu,refInput){
    $("#checkName").remove();
    if(!(/^[a-zâäàéèùêëîïôöçñ \-]+$/i.test(contenu)) && contenu !=""){
        $(refInput).parent().append("<div id='checkName' class='text-danger'></div>");
        $("#checkName").html("Veuillez saisir un prenom correct (uniquement des lettres et non vide).");
        return 0;
    }
    return 1;
}

$(document).on("change","#switch",function(){
    console.log($(this));
    var choice=0; // non coché
    if ($(this).is(':checked')){ // si il est coché
        choice=1;
    }

    $.ajax({
        type: "POST",
        url: "./minControleur/dataProfil.php",
        data: {"action":"changeValue","choice":choice},
        success: function(oRep){
           
        },
    dataType: "text"
    });

});