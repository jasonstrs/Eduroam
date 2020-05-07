function chargerToutesLesDates(ville){
        nbDates("attente",ville);
        nbDates("validees",ville);
        nbDates("mesAttentes",ville);
        nbDates("mesValidees",ville);
        chargerDatesUsers("attente",ville);
        chargerDatesUsers("validees",ville);
        chargerDatesUsers("mesAttentes",ville);
        chargerDatesUsers("mesValidees",ville);
}


/**
 * Récupère le nombre de dates
 * valide : 1 -> dates validées
 *          2 -> dates en attente
 *          3 -> en attente & user interessé
 *          4 -> validé & user interessé
 */
function nbDates(valide,choixVille){
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"nbDatesUser",
            val:valide,
            ville : choixVille,
            idU:sessionStorage.getItem("idU")
        },
        success:function(oRep){
            var tab = JSON.parse(oRep);
            var id;
            switch(tab.valid){
                case "validees":
                    id="#nbDatesValidees";
                break;
                case "attente":
                    id="#nbDatesEnAttente";
                break;
                case "mesValidees":
                    id="#nbVosDatesEnAttente";
                break;
                case "mesAttentes":
                    id="#nbVosDatesValidees";
                break;
                default:
                    console.log("Erreur lors du chargement du nombre de dates");
                break;
            }
            $(id).html(tab.rep);
        },
        error:function(oRep){
            var id="#nbDatesEnAttente";
            if(oRep.valid == 1)id="#nbDatesValidees"
            $(id).html("Erreur");
        }
    });
}


/**
 * Recherche l'indice d'un élément(entier) dans un tableau multidimensionnel.
 * 
 */
function trouverElt(tab,elt,colonne){

    for(i=0;i<tab.length;i++){

        if(elt == tab[i][colonne])break;
    }
    if(i<tab.length)return i;
    return -1;
}

/**
 * 
 * @param {*} tab 
 * @param {*} elt 
 */
function getElementTab(tab,elt){
    var rep = new Array();
    tab.forEach(element => {
        rep.push(element[elt]);
    });
    return rep;
}


/**
 * Déclare que l'utilisateur est interessé ou désinteressé des dates de tableauDates
 * @param {int} choix 2 si l'utilisateur veut se désintéresser, 1 si il veut s'interesser aux dates
 * @param {[Object]} tabDates Le tableau des dates sur lesquelles effectuer l'action
 */
function inscriptionDates(choix,tabDates){
    var requete = {
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"userInteresseDates",
            valeur:choix,
            dates:JSON.stringify(tabDates),
            idU:sessionStorage.getItem("idU")
        },
        success:function(oRep){
            var rep = JSON.parse(oRep);
            console.log(rep);
            if(rep["choix"] == 1)Cookies.set("succes",rep["nb"]+" date(s) ajoutée(s) à Vos Dates en Attente");
            else if(rep["choix"] == 2)Cookies.set("succes",rep["nb"]+" date(s) retirée(s)♠ de Vos Dates en Attente");
            window.location.reload();
        }
    }
    $.ajax(requete);
}

/**
 * Charge les dates (Description du spectacle, ville, date, nb)
 * valide : 1 -> dates validées
 *          2 -> dates en attente
 *          3 -> Vos dates validées
 *          4 -> Vos dates en attente
 */
function chargerDatesUsers(valide,choixVille){
    
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"chargerDates",
            val:valide,
            tri:$("#selectTri").val(),
            ville : choixVille,
            idU:sessionStorage.getItem("idU")
        },
        success:function(oRep){
            
            var tab = JSON.parse(oRep);
            //Id du tableau (change en fonction de valid)
            var id="#collapseOne";
            //Classe du tableau (Les cellules du tableau des dates valides doivent pouvoir être cliquables)
            var classeTab="table table-striped";
            //Actions réalisables sur les dates (Valider/Supprimer pour les non validées, Archiver/Supprimer pour les validées)
            var thead="";
            contenuTab = new Array();
            finTab="";
            lien="";
            var datesSelec = new Array();
            
            switch(tab.valid){
                case "validees":
                    //Dates validées
                    //On affiche les infos basiques
                    //On ajoute un lien cliquable vers la vente de billets
                    thead="<tr><th>Description</th><th>Ville</th><th>Date</th><th>Nombre d'Inscrits</th><th>Lien disponible</th></tr>";
                    id="#collapseTwo";
                    classeTab="table table-hover pointer nonSelectionnable";
                break;

                case "attente":
                    //Dates en attente
                    thead="<tr><th>Description</th><th>Ville</th><th>Date</th><th>Nombre d'Inscrits</th></tr>";
                    classeTab="table table-striped  pointer nonSelectionnable";
                    id="#collapseOne";
                    
                break;

                case "mesValidees":
                    //Vos dates validées
                    thead="<tr><th>Description</th><th>Ville</th><th>Date</th><th>Nombre d'Inscrits</th><th>Lien disponible</th></tr>";
                    id="#collapseFour";
                    classeTab="table table-hover pointer nonSelectionnable";
                break;

                case "mesAttentes":
                    //Vos dates en attente
                    thead="<tr><th>Description</th><th>Ville</th><th>Date</th><th>Nombre d'Inscrits</th></tr>";
                    id="#collapseThree";
                    classeTab="table table-stripped pointer nonSelectionnable";
                    
                break;
            }

            if(tab.rep.length == 0 ){
                $(id).html(" <i style='padding:20px;display:block;'>Aucune date</i>");
                return;
            }

            var table = $("<table/>").addClass(classeTab);
            table.append($("<thead/>").html(thead));
            var tbody=$("<tbody/>");
            if(tab.valid == "validees" || tab.valid == "mesValidees"){
                tab["rep"].forEach(element => {
                    var currLigne=$("<tr/>");
                    //Affiche une croix si le lien n'est pas renseigné, un V sinon.
                    var affichageLienDispo = "<i class='fas fa-times' style='color:red'></i>";

                    if(element.lien != ""){
                        //Si le lien est renseigné, on peut cliquer sur la ligne pour rediriger vers le site de vente.
                        currLigne.click(function(){window.open(element.lien,"_blank")});
                        var affichageLienDispo = "<i class='fas fa-check' style='color:green'></i>"
                    }

                    currLigne
                    .append($("<td/>").html(element.description))
                    .append($("<td/>").html(element.ville))
                    .append($("<td/>").html(traduireDate(element.dateSpectacle)))
                    .append($("<td/>").html(element.nbInscrits))
                    .append($("<td/>").html(affichageLienDispo));

                    tbody.append(currLigne);
                });
            }
            else{
                var pair=1;
                tab["rep"].forEach(element => {
                    var currLigne=$("<tr/>").addClass("ligneTab").data({"selec":0,"idDate":element.idDate,"date":element.dateSpectacle,"valid":tab.valid,"idSpectacle":element.idSpectacle});
                    if(pair){
                        pair--;
                        currLigne.data({"couleurNonS":"#F2F2F2","couleurS":"rgb(55, 55, 55)"});
                    }
                    else{
                        pair++;
                        currLigne.data({"couleurNonS":"#FFFFFF","couleurS":"rgb(110, 110, 110)"});
                    }

                    currLigne.click(function(){
                        var boutonAction = $("<button/>").addClass("btn btn-block");
                        /**
                         * Couleurs du tableau : 
                         *  Lignes paires : #F2F2F2
                         *  Lignes impaires : #FFFFFF
                         */
                        if($(this).data("selec") == 0){
                            //Si la ligne n'est pas selectionnée, on la sélectionne => on la met dans un tableau, et on la met en couleur
                            $(this).css({"background-color":$(this).data("couleurS"),"color":"white"});
                            $(this).data("selec",1);
                            datesSelec.push($(this).data());
                        }
                        else{
                            //Si la ligne est selectionnée, on la déselectionne => on l'enlève du tableau, et on remet sa couleur de base
                            $(this).css({"background-color":$(this).data("couleurNonS"),"color":"#212529"});
                            $(this).data("selec",0);
                            
                            var indice = trouverElt(datesSelec,$(this).data("idDate"),"idDate");

                            datesSelec.splice(indice,1);
                        }
                        if($(this).data("valid") == "attente"){
                        boutonAction.addClass("btn-outline-success").html("Ces dates m'intéressent !").click(function(){
                            inscriptionDates(1,datesSelec);
                        });
                        }
                        else{
                            boutonAction.addClass("btn-outline-danger").html("Ces dates ne m'intéressent plus!").click(function(){
                                inscriptionDates(2,datesSelec);
                            });
                        }

                        $("#infosDatesSelectionnees").css("display","none"); //Permet de corriger un pb d'affichage
                        /**
                         * Si il y a des dates à afficher, on en affiche le nombre, et les actions possibles.
                         */
                        if(datesSelec.length > 0){
                            $("#infosDatesSelectionnees").html("<big>" +datesSelec.length + "</big> date(s) sélectionnée(s)");
                            $("#infosDatesSelectionnees").append(boutonAction);
                            $("#infosDatesSelectionnees").css("display","block").animate({
                                opacity:1,
                                bottom:"100px"
                            },100);
                        }
                        else{
                            $("#infosDatesSelectionnees").animate({
                                opacity:0,
                                bottom:"150px"
                            },200,function(){
                                $("#infosDatesSelectionnees").empty().css("display","none");
                            });
                        }
                    });
                    currLigne
                    .append($("<td/>").html(element.description))
                    .append($("<td/>").html(element.ville))
                    .append($("<td/>").html(traduireDate(element.dateSpectacle)))
                    .append($("<td/>").html(element.nbInscrits)
                    
                    );

                    tbody.append(currLigne);
                });
            }
            table.append(tbody);
            $(id).empty();
            $(id).append(table)
        },
        error:function(oRep){
            var id="#nbDatesEnAttente";
            if(oRep.valid == 1)id="#nbDatesValidees"
            $(id).html("Erreur lors du chargement des dates");
        }
    });
}


/**
 * AU CHARGEMENT DE LA PAGE
 */
$("#accordionUser").ready(function(){
    console.log("L'accordéon User est chargé");
    /**
     * Chargement des dates en attente
     */
    nbDates("attente");
    chargerDatesUsers("attente");
    /**
     * Chargement des dates validées
     */
    nbDates("validees");
    chargerDatesUsers("validees");
    /**
     * Chargement des dates en attente où l'utilisateur s'est inscrit
     */
    nbDates("mesAttentes");
    chargerDatesUsers("mesAttentes");
    /**
     * Chargement des dates validées où l'utilisateur se'st inscrit
     */
    nbDates("mesValidees");
    chargerDatesUsers("mesValidees");
    $("#selectTri").change(function(){
        var ville = $("#txtRechercheVilleUser").val();
        chargerToutesLesDates(ville);
    });
    
    $(".card-header").click(function(){
        datesSelec = new Array();
        $("#infosDatesSelectionnees").animate({
            opacity:0,
            bottom:"150px"
        },200,function(){
            $("#infosDatesSelectionnees").empty().css("display","none");
        });
        $(".ligneTab").each(function(){
            $(this).data("selec",0).css({"background-color":$(this).data("couleurNonS"),"color":"#212529"});
        });
    });

    $("#btnRechercheVilleUser").click(function(){
        var ville = $("#txtRechercheVilleUser").val();
        chargerToutesLesDates(ville);
    });
});



