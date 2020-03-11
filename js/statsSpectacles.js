

/**
 * Récupère le nombre de dates
 * valide : 1 -> dates validées
 *          2 -> dates en attente
 */
function nbDates(valide){
    console.log(valide);
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"nbDates",
            val:valide
        },
        success:function(oRep){
            var tab = JSON.parse(oRep);
            console.log(tab);
            console.log(tab.valid);
            var id="#nbDatesEnAttente";
            if(tab.valid == 1)id="#nbDatesValidees";
            $(id).html(tab.rep);
            console.log(id);
        },
        error:function(oRep){
            var id="#nbDatesEnAttente";
            if(oRep.valid == 1)id="#nbDatesValidees"
            $(id).html("Erreur");
        }
    });
}

/**
 * Charge les dates en attente (Description du spectacle, ville, date, nb)
 */
function chargerDatesEnAttente(){

}
/**
 * Charge les dates validées (Description du spectacle, ville, date, nb)
 */
function chargerDatesValides(){

}

/**
 * AU CHARGEMENT DE LA PAGE
 */
$("#accordion").ready(function(){
    
    nbDates(2);
    chargerDatesEnAttente();
    nbDates(1);
    chargerDatesValides();

});