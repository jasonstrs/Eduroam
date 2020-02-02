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
    var rep;
    $.ajax({
        method:"GET",
        url:"./minControleur/dataSpectacle.php",
        async:false,
        data:{
            action:"verifVilleNom",
            nom:nomVille
        },
        success:function(oRep){
            
            
            oRep = JSON.parse(oRep);
            rep = oRep;
            
            
        },
        error : function(oRep){
            console.log("Erreur");
            console.log(oRep);
        } 
    });
    return rep;
}

$(document).ready(function(){
    $("#validerEntreeVille").click(function(){
        var cont_info;
        var info;
        var classes;
        var position = $("#validerEntreeVille").position().left + $("#validerEntreeVille").width()+30;
        var currLoader = loader.clone(1).css({"position":"absolute","left":position,"margin-top":"-6px"});
        var reponseVerifVille;
        if(!$("#entrerVille").children().last().is($(this))){
            $("#entrerVille").children().last().remove();
        }
        $(this).prop("disabled",true);
        $("#entrerVille").append(currLoader[0]);
        
        reponseVerifVille = verifVille($("#champTxtVille").val());
        /**On récupère :    le nom qui vient d'être entré
         *                  l'id de la ville en question
         *                  la ville se trouve déja dans la bdd (false) ou non (true)
        */
        if(reponseVerifVille[2] == false){
            //La ville se trouve déja dans la BDD, on ajoute ou modifie des dates
            classes = "alert alert-warning";
            info = "Des dates sont déja prévues à <b>"+reponseVerifVille[0]+" </b>!<br> <a href='./index.php?view=editerSpectacle&ville="+reponseVerifVille[0]+"'>Cliquez ici pour les modifier / en ajouter</a>";
            $("#listeVilles").delay(500).slideDown(500);
        }
        else{
            //La ville n'est pas dans la BDD, on va choisir de nouvelles dates
            classes = "alert alert-success";
            info = "Veuillez <b>choisir des dates</b> pour <b>"+reponseVerifVille[0]+" </b>!";
            $("#listeVilles").delay(500).slideUp(500);
        }

        window.setTimeout(function(){
            //On affiche l'info voulue
            $("#entrerVille").children().last().hide();
            $("#validerEntreeVille").prop("disabled",false);
            cont_info = $("<div/>").addClass(classes).attr("role","alert")
            .html(info)
            .css("font-size","smaller").hide();
            $("#entrerVille").append(cont_info);
            $("#entrerVille").children().last().slideDown(500);
            
        },200);

            
            
    });
    $("#champTxtVille").on("input",function(){
        
        if($(this).val() == "")
        {
            $("#validerEntreeVille").prop("disabled",true);
        }
        else $("#validerEntreeVille").prop("disabled",false);
    });
});