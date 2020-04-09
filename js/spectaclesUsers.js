/**
 * Récupère le nombre de dates
 * valide : 1 -> dates validées
 *          2 -> dates en attente
 *          3 -> en attente & user interessé
 *          4 -> validé & user interessé
 */
function nbDates(valide){
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"nbDatesUser",
            val:valide,
            idU:$("#valIdUser").val()
        },
        success:function(oRep){
            var tab = JSON.parse(oRep);
            var id;
            console.log(tab);
            switch(tab.valid){
                case 1:
                    id="#nbDatesValidees";
                break;
                case 2:
                    id="#nbDatesEnAttente";
                break;
                case 3:
                    id="#nbVosDatesEnAttente";
                break;
                case 4:
                    id="#nbVosDatesValidees";
                break;
                default:
                    console.log("Erreur lors du chargement du nombre de dates");
                break;
            }
            console.log(id);
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
 * Charge les dates (Description du spectacle, ville, date, nb)
 * valide : 1 -> dates validées
 *          2 -> dates en attente
 */
function chargerDatesStats(valide){
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"chargerDates",
            val:valide,
            tri:$("#selectTri").val()
        },
        success:function(oRep){
            
            var tab = JSON.parse(oRep);
            console.log(tab);
            //Id du tableau (change en fonction de valid)
            var id="#collapseOne";
            //Classe du tableau (Les cellules du tableau des dates valides doivent pouvoir être cliquables)
            var classeTab="table table-striped";
            //Actions réalisables sur les dates (Valider/Supprimer pour les non validées, Archiver/Supprimer pour les validées)
            var finTab="<th>Valider</th><th>Supprimer</th>"
            if(tab.valid == 1){
                id="#collapseTwo";
                classeTab="table table-hover pointer";
                var finTab="<th>Supprimer</th>"
            }
            if(tab.rep.length == 0 ){
                $(id).html(" <i>Aucune date</i>");
                return;
            }
            var table = $("<table/>").addClass(classeTab);
            table.append($("<thead/>").html('<tr><th>Description</th><th>Ville</th><th>Date</th><th>nbInscrits</th>'+finTab+'</tr>'));
            var tbody=$("<tbody/>");
            tab["rep"].forEach(element => {
                var currLigne=$("<tr/>");
                currLigne
                .append($("<td/>").html(element.description))
                .append($("<td/>").html(element.ville))
                .append($("<td/>").html(traduireDate(element.dateSpectacle)))
                .append($("<td/>").html(element.nbInscrits));
                if(tab.valid == 0)currLigne.append($("<td/>").addClass("validDateStats").html("<i class='fas fa-check'></i>").click(function(){

                }));
                currLigne.append($("<td/>").addClass("suppDateStats").html("<i class='fas fa-trash-alt'></i>").click(function(){

                }));
                
                
                if(tab.valid == 1){
                    //Si on veut les dates validées
                }
                tbody.append(currLigne);
            });
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
    nbDates(2);
    //chargerDatesUser(2);
    nbDates(1);
    //chargerDatesUser(1);
    nbDates(3);
    nbDates(4);
    $("#selectTri").change(function(){
        //chargerDatesUser(2);
        //chargerDatesUser(1);
    });
});



