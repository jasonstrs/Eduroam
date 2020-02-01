/**
 * Envoie une requête AJAX pour récupérer les villes où un spectacle est prévu
 * le nombre de dates possibles, et le nombre d'inscrits.
 */

function chargerVilles(){
    $.ajax({
        method:"GET",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"chargerVilles"
        },
        success:function(oRep){
            afficherResumeVilles(oRep);
        },
        error : function(oRep){
            console.log("Erreur lors de la récupération des villes.");
        } 
    });
}

/**
 * Affiche toutes les villes où des spectacles sont en cours de création
 * sous la forme Ville | Nb de dates | Nb d'inscrits (toutes dates confondues)
 * 
 * @param {*} rep tableau [nomDeLaVille,NbDeDates,NbDInscrits]
 */
function afficherResumeVilles(rep){
    var tab = JSON.parse(rep);
    tab.forEach(element => {
        var currVille = $("<div/>").addClass("ville")
            .append($("<table/>")
                .append($("<td/>").html(element[0]))
                .append($("<td/>").html(element[1]+" Date(s)"))
                .append($("<td/>").html(element[2]+" Inscrit(s)"))
            )
        ;
        $("#listeVilles").append(currVille);
        
    });
}


/**
 * Fonction qui vérifie si la vile dont le nom est passé en paramètre est dans la BDD où non.
 * @param {*} nom Nom de la ville dont on veut vérifier l'abscence dans la BDD
 */
function verifVille(nomVille){
    $.ajax({
        method:"GET",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"verifVilleNom",
            nom:nomVille
        },
        success:function(oRep){
            var cont_info;
            var info;
            var classes;
            oRep = JSON.parse(oRep);
            
            if(oRep[1] == 0){
                classes = "alert alert-warning";
                info = "<b>"+oRep[0]+" </b>  a déja des dates!<br> Cliquez ici pour les modifier / en ajouter"
            }
            else{
                classes = "alert alert-success";
                info = "<b>"+oRep[0]+" </b> n'a pas encore de dates! <br>Veuillez maintenant <b>choisir des dates </b>!"
            }
            window.setTimeout(function(){
                //La ville est déja dans la BDD => On affiche une erreur comportant un lien vers la page de modification de la ville
                $("#entrerVille").children().last().hide();
                $("#validerEntreeVille").show(200);
                cont_info = $("<div/>").addClass(classes).attr("role","alert")
                .html(info)
                .css("font-size","smaller").hide();
                $("#entrerVille").append(cont_info);
                $("#entrerVille").children().last().slideDown(500);
                
            },200);
        },
        error : function(oRep){
            console.log("Erreur lors de la récupération des villes.");
        } 
    });
}

$(document).ready(function(){
    $("#validerEntreeVille").click(function(){
        var currLoader = loader.clone(1);
        console.log(currLoader[0]);
        console.log($("#entrerVille").children().last());
        if(!$("#entrerVille").children().last().is($(this))){
            $("#entrerVille").children().last().remove();
        }
        $(this).hide()
        $("#entrerVille").append(currLoader[0]);
        
        verifVille($("#champTxtVille").val())
            
            
    });
    $("#champTxtVille").on("input",function(){
        
        if($(this).val() == "")
        {
            $("#validerEntreeVille").prop("disabled",true);
        }
        else $("#validerEntreeVille").prop("disabled",false);
    });
});