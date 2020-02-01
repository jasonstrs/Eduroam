function chargerVilles(){
    console.log("Récupération des villes...");
    $.ajax({
        method:"GET",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"chargerVilles"
        },
        success:function(oRep){
            console.log("Succès");
            console.log(oRep);
            afficherVilles(oRep);
        },
        error : function(oRep){
            console.log("Erreur");
            console.log(oRep);
        } 
    });
}

function afficherVilles(rep){
    console.log("Affichage des villes...");
    var tab = JSON.parse(rep);
    console.log(rep);
    tab.forEach(element => {
        console.log("On crée la case : "+element);
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

/*

    <div class="ville">
            <table >
                <td>Paris</td>
                <td>12 Date(s)</td>
                <td>610 Inscrit(s)</td>
            </table>
        </div>

*/