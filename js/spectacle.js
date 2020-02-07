/**
 * Envoie une requête AJAX pour récupérer les villes où un spectacle est prévu
 * le nombre de dates possibles, et le nombre d'inscrits.
 */

function chargerVilles(nomEntre){
    $.ajax({
        method:"GET",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"chargerVilles",
            nom:nomEntre
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
        var currVille = $("<div/>").addClass("containerVille").append($("<div/>").addClass("ville")
            .append($("<table/>")
                .append($("<td/>").html(element.ville))
                .append($("<td/>").html(element.nbDates+" Date(s)"))
                .append($("<td/>").html(element.nbInteresses+" Inscrit(s)"))
            )
            ).data("ville",element);
        ;        
        $("#listeVilles").append(currVille);
        console.log(currVille.data("ville"));
        var data = currVille.data("ville");
        var currDesc = $("<div/>").addClass("descVille").prepend($("<B/>").html(data["desc"]));
        data["dates"].forEach(element => {
            currDesc.append(
                $("<div/>").addClass("contDate").append($("<div/>").addClass("date").html(element.dateSpectacle))
                .append($("<div/>").addClass("date").html(element.nb+" personnes interessée(s)"))
            );
        });
        
        currVille.append(currDesc);

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
        //Contenu de l'alerte qui sera affichée
        var cont_info;
        var info;
        var classes;
        //Position du gif loader
        var position = $("#validerEntreeVille").position().left + $("#validerEntreeVille").width()+30;
        //Loader
        var currLoader = loader.clone(1).css({"position":"absolute","left":position,"margin-top":"-6px"});
        //Tableau contenant la réponse de la requête AJAX
        var reponseVerifVille;

        var villeEntree = $("#champTxtVille").val();

        //On affiche toutes les villes, et on cache les dates
        $("#listeVilles").slideUp(400);
        $(".descVille").slideUp();
        $(".containerVille").delay(200).slideDown();
        

        //Si le bouton n'est pas le dernier élément de la section, on supprime ce dernier élément
        //Le dernier élément ne peut normalement être que le bouton ou une alerte
        if(!$("#entrerVille").children().last().is($(this))){
            $("#entrerVille").children().last().slideUp(400,function(){$(this).remove()});
        }

        //Si le champ texte est vide, on affiche toutes les villes, ET ON NE LANCE PAS LA REQUETE AJAX
        if(villeEntree == ""){
            $("#listeVilles").slideDown(400);
            return;
        }

        //On désactive le bouton tant que la requête ne'st pas terminée
        $(this).prop("disabled",true);
        //On affiche le loader
        $("#entrerVille").append(currLoader[0]);

        reponseVerifVille = verifVille(villeEntree);
        /* 
            Structure récupérée : 
            id : id du spectacle,
            desc : description du spectacle,
            ville : ville où va avoir lieu le spectacle,
            nbSpecVille : nombre de spectacles pour cette ville
            nbDates : nombre de dates total
            nbInteresses : nombre de personnes interessées
            dates : [
                idSpectacle,
                idDate,
                date,
                nb : nombre de personnes pour cette date
            ]
        
        */
        if(reponseVerifVille[2] == false){
            //La ville se trouve déja dans la BDD, on ajoute ou modifie des dates
            classes = "alert alert-warning";
            info = "Des dates sont déja prévues à <b>"+reponseVerifVille[0]+" </b>! (Voir ci dessous)<br> <a href='./index.php?view=editerSpectacle&ville="+reponseVerifVille[0]+"'>Cliquez ici pour les modifier / en ajouter</a>";
            //$("#listeVilles").delay(500).slideDown(500);
        }
        else{
            //La ville n'est pas dans la BDD, on va choisir de nouvelles dates
            classes = "alert alert-success";
            info = "Veuillez <b>choisir des dates</b> pour <b>"+reponseVerifVille[0]+" </b>!";
            $("#listeVilles").delay(100).slideUp(500);
        }

        //On affiche l'info voulue
        //On cache le loader
        $("#entrerVille").children().last().delay(200).hide();
        //On réactive le bouton
        $("#validerEntreeVille").prop("disabled",false);
        //On affiche l'alerte
        cont_info = $("<div/>").addClass(classes).attr("role","alert")
        .html(info)
        .css("font-size","smaller").hide();
        $("#entrerVille").append(cont_info);
        $("#entrerVille").children().last().delay(500).slideDown(400);
            

        $(".containerVille").each(function(){
            if($(".ville table td:first",$(this)).html().toUpperCase() == $("#champTxtVille").val().toUpperCase()){
                $(".descVille",$(this)).delay(200).slideDown(200);
            }
            else{
                $(this).slideUp(400);
            }
        });    
        $("#listeVilles").delay(500).slideDown(400);
            
    });
    //Désactive le bouton si le champ texte est vide
    /* $("#champTxtVille").on("input",function(){
        
        if($(this).val() == "")
        {
            $("#validerEntreeVille").prop("disabled",true);
        }
        else $("#validerEntreeVille").prop("disabled",false);
    }); */

    
    $(document).on("click",".ville",function(){
        /* $(".descVille",$(this)) */$(this).next().slideToggle(200);
        


    });
    

});