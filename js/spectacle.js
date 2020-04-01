/**
 * Envoie une requête AJAX pour récupérer les villes où un spectacle est prévu
 * le nombre de dates possibles, et le nombre d'inscrits.
 */

function chargerVilles(nomEntre){
    $.ajax({
        method:"POST",
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
 * Affiche les spectacles sont en cours de création
 * sous la forme Description | Ville | Nb de dates | Nb d'inscrits (toutes dates confondues)
 * 
 * @param {array} rep structure suivante : 
 *			id : id du spectacle,
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
function afficherResumeVilles(rep){
    var tab = JSON.parse(rep);
    if(tab.length == 0){
        $("#listeVilles").append($("<div/>").html("<I><B>Aucun spectacle en attente</B></I>").css("margin","20px"));
    }
    tab.forEach(element => {
        var currVille = $("<div/>").data("ville",element).addClass("containerVille nonSelectionnable").append($("<div/>").addClass("ville")
            .append($("<div/>").addClass("tabVille")
                .append($("<div/>").addClass("eltTabVille").css({"flex":"4","font-weight":"bolder"}).html(element.desc))
                .append($("<div/>").addClass("eltTabVille").css("flex","2").html(element.ville))
                .append($("<div/>").addClass("eltTabVille").css("flex","1").html(element.nbDates+" Date(s)"))
                .append($("<div/>").addClass("eltTabVille").css("flex","1").html(element.nbInteresses+" Inscrit(s)"))
            )
            )
        ;        
        $("#listeVilles").append(currVille);
        var data = currVille.data("ville");
        var currDesc = $("<div/>").addClass("descVille");
        var contenuModal;
        var requete;
        if(data["dates"]["length"] == 0) currDesc.append($("<div/>").html("<I><B>Aucune date pour ce spectacle</B></I>").css("margin","10px"));
        data["dates"].forEach(date => {
            currDesc.append(
                //Bouton pour supprimer une date
                $("<div/>").addClass("contDate").append(
                    $("<div/>").addClass("date").html(traduireDate(date.dateSpectacle))
                ).append(
                    $("<div/>").addClass("date").html("<b>"+date.nb+"</b> personne(s) interessée(s)")
                ).append(
                    $("<div/>").addClass("validDate").html("<i class='fas fa-check'></i>").data({"idSpec":element.id,"idDate":date.idDate,"date":date.dateSpectacle,"ville":element.ville,"desc":element.desc})
                    .click(function(){
                        /**                                                                                                                             
                         *                                      CREATION DU MODAL DE VALIDATION DE DATE                                                 
                         */
                        var id = "modalValiderDate";
                        var     contenu = "Valider cette date : <B>"+$(this).data("date")+"</B> du spectacle <B>"+$(this).data("desc")+"</B> à <B>"+ $(this).data("ville")+"</B> ?<br/>";
                                contenu += "Les gens interessés reçevront un mail leur confirmant la validation. <br>( Voir le mail dans <a href='#'>Administration>Spectacles>Notifications</a> )<br><br>";
                                contenu += "Veuillez entrer le lien de la vente de billets : (Modifiable plus tard)<br>";
                        var modal = $("<div/>").addClass("modal fade").attr({"tabindex":"-1","role":"dialog","id":id,"aria-labelledby":id,"aria-hidden":"true"}).append(
                            $("<div/>").addClass('modal-dialog modal-lg').attr("role","document").append(
                                $("<div/>").addClass("modal-content").append(
                                    $("<div/>").addClass("modal-header").append(
                                        $("<h5/>").addClass("modal-title").attr("id",id).html("Valider une date")
                                    ).append(
                                        $("<button/>").addClass("close").attr({"type":"button","data-dismiss":"modal","aria-label":"Close"}).append(
                                            $("<span/>").html("&times;").attr("aria-hidden","true")
                                        )
                                    )
                                ).append(
                                    $("<div/>").addClass("modal-body").html(contenu+'<input type=text class="form-control" id="txtLienValidDate" placeholder="Entrer le lien de la vente de billets">')
            
                                ).append(
                                    $("<div/>").addClass("modal-footer").append(
                                        $("<button/>").addClass("btn btn-secondary").attr({"type":"button","data-dismiss":"modal"}).html("Fermer")
                                    ).append(
                                        $("<button/>").addClass("btn btn-outline-success").data("idDate",$(this).data("idDate")).attr({"type":"button"}).html("Valider la Date").click(function(){
                                            $.ajax({
                                                method:"POST",
                                                url:"./minControleur/dataSpectacle.php",
                                                data:{
                                                    "action":"validDate",
                                                    "idDate":$(this).data("idDate"),
                                                    "lien":$("#txtLienValidDate").val()
                                                },
                                                success:function(oRep){
                                                    console.log("Date validée");
                                                    $("#modalValiderDate").modal('dispose');
                                                    document.location.reload();
                                                }
                                            })
                                        })
                                    )
                                
                                )
                            )
                        ).on("hidden.bs.modal",function(e){
                            console.log("On supprime le modal");
                            $(this).remove();
                        });
                        $("body").append(modal);
                        /**                                                                                                                             
                         *                                      FIN CREATION DU MODAL DE VALIDATION DE DATE                                                 
                         */
                        $("#modalValiderDate").modal();
                    })
                    
                ).append(
                    //Bouton pour supprimer une date
                    $("<div/>").addClass("suppDate").html("<i class='fas fa-trash-alt'></i>").data({"idSpec":element.id,"idDate":date.idDate,"date":date.dateSpectacle,"ville":element.ville,"desc":element.desc})
                    .click(function(){
                        
                        requete = {
                            method:"POST",
                            url:"./minControleur/dataSpectacle.php",
                            data:{
                                "action":"supprDate",
                                "idSpectacle":$(this).data("idSpec"),
                                "idDate":$(this).data("idDate"),
                            },
                            success:function(oRep){

                                console.log("Date supprimée");
                                $("#modalSupprDate").modal('dispose');
                                document.location.reload();
                            }
                        }
                        contenuModal = "Spectacle : <b>"+$(this).data("desc")+"</b> à <b>"+$(this).data("ville")+"</b>";
                        contenuModal += "<br>Date : <b>"+$(this).data("date")+"</b>";
                        contenuModal += "<br>Voulez vous <B>supprimer cette date</B> ? ";

                        

                        creerModal("modalSupprDate","Supprimer cette date?",contenuModal,"Supprimer","btn btn-outline-danger",requete);
                        $("#modalSupprDate").modal();
                    }))
                        
            );
        });
        currDesc.append($("<button/>").addClass("ajouterDateSpectacle pointer btn btn-outline-primary").html("Ajouter une date à ce spectacle").click(function(){
            $("body").data("idSpectacle",$(this).parent().parent().data("ville").id);
            afficherChoixDate(element);
        }));
        currDesc.append($("<button/>").addClass("ajouterDateSpectacle pointer btn btn-outline-danger").html("Supprimer ce spectacle").click(function(){
            var spectacle = $(this).parent().parent().data("ville");
            console.log(spectacle);
            var contenuModal = "Voulez vous vraiment supprimer le spectacle \""+spectacle.desc+"\" à "+spectacle.ville+"?";
            var requete ={
                method:"POST",
                url:"./mincontroleur/dataSpectacle.php",
                data:{
                    action:"supprSpectacle",
                    id:spectacle.id
                },
                success:function(oRep){
                    console.log("Spectacle supprimé");
                    $("#modalSupprSpectacle").modal('dispose');
                    document.location.reload();
                }
                
            };
            creerModal("modalSupprSpectacle","Supprimer un spectacle",contenuModal,"Supprimer","btn btn-danger",requete);
            $("#modalSupprSpectacle").modal();
        }));
        
        currVille.append(currDesc);
        
    });
    $("#listeVilles").append(
        $("<div/>").attr("id","boutonCreerSpectacle").html("Créer un nouveau spectacle").click(function(){
            $("body").data("idSpectacle",null);
            afficherChoixDate();
        })
    );
}


/**
 * Cette fonction va remplir et afficher en fonction du contexte (element)
 * la div "choixDates"
 * 
 * Si typeof element => object :
 *      On a fourni un spectacle existant, on n'a donc qu'à choisir les nouvelles dates
 * Si typeof element => string :
 *      On a entré un nom de ville, on doit donc choisir la description du spectacle + les dates
 * Si typeof element => undefined :
 *      On a rien entré, on doit choisir un nom de ville, une description et des dates.
 */

function afficherChoixDate(element){
    var titre;
    var ville, desc;
    $("#choisirDates").slideUp(400,function(){
        $("#champTxtVilleBis").val("").attr("disabled",false);
        $("#champTxtDescSpectacle").val("").attr("disabled",false);
        switch(typeof(element)){
            case "object":
                //On veut ajouter une/des date(s) à un spectacle existant
                titre = "Choix des dates";
                ville=element.ville;
                desc = element.desc;
                $("#champTxtVilleBis").val(ville).attr("disabled",true);
                $("#champTxtDescSpectacle").val(desc).attr("disabled",true);
            break;
            case "string":
                //On veut créer un nouveau spectacle, dont on a déja specifié la ville
                console.log("string");
                titre = "Choix de la description, et des dates";
                ville=element;
                $("#champTxtVilleBis").val(ville);
            break;
            case "undefined":
                //On veut créer un nouveau spectacle
                titre = "Création d'un nouveau spectacle";
            break;
        }
        $(".champnomDesc").trigger("input");
        window.setTimeout(function(){$("#choisirDates .gras:first").html(titre)},200);
        $("#choisirDates").slideDown(300,function(){
            $('html, body').animate({
                scrollTop:$("#choisirDates").offset().top
            }, 'slow');
        });
        
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


/**
 * input type="date"
 */
var selectDate = $("<input/>").attr({"type":"date"}).addClass("inputDate pointer").change(function(){
    if($(this).val()=="" && $(".inputDate").length > 1)$(this).remove();
});

$(document).ready(function(){
    
    /**
     * Au clic sur le bouton de recherche de ville
     * Si la ville est déja en bdd, affiche les spectacles en attente dans cette ville
     * Sinon propose de choisir des dates pour la ville
     */
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
        $("#listeVilles").slideUp(300);
        $(".descVille").delay(500).slideUp(0);
        $(".containerVille").delay(500).slideDown(0);
        $("#choisirDates").slideUp();
        

        //Si le bouton n'est pas le dernier élément de la section, on supprime ce dernier élément
        //Le dernier élément ne peut normalement être que le bouton ou une alerte
        if(!$("#entrerVille").children().last().is($(this))){
            $("#entrerVille").children().last().slideUp(200,function(){$(this).remove()});
        }

        //Si le champ texte est vide, on affiche toutes les villes, ET ON NE LANCE PAS LA REQUETE AJAX
        if(villeEntree == ""){
            $("#listeVilles").slideDown(300);
            return;
        }

        //On désactive le bouton tant que la requête ne'st pas terminée
        $(this).prop("disabled",true);
        //On affiche le loader
        $(".loader:first").show();

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
        if(reponseVerifVille[1] == false){
            //La ville se trouve déja dans la BDD, on ajoute ou modifie des dates
            classes = "alert alert-warning";
            info = "Des dates sont déja prévues à <b>"+reponseVerifVille[0]+" </b>! (Voir ci dessous)<br>Vous pouvez ajouter des dates aux spectacles existants, ou créer un nouveau spectacle";
            
        }
        else{
            //La ville n'est pas dans la BDD, on va choisir de nouvelles dates
            classes = "alert alert-success";
            info = "Veuillez <b>choisir des dates</b> pour <b>"+reponseVerifVille[0]+" </b>!";
           
        }

        //On affiche l'info voulue (définie par le if...else précédent)

        //On cache le loader
        $(".loader").children().last().hide();
        //On réactive le bouton
        $("#validerEntreeVille").prop("disabled",false);
        //On affiche l'alerte
        cont_info = $("<div/>").addClass(classes).attr("role","alert")
        .html(info)
        .css("font-size","smaller").hide();
        $("#entrerVille").append(cont_info);
        $("#entrerVille").children().last().slideDown(0);
            
        //On affiche les spectacles dont la ville correspond à la ville entrée.
        $(".containerVille").each(function(){
            //On compare les noms en majuscule.
            if($(".ville .tabVille .eltTabVille:nth-child(2)",$(this)).html().toUpperCase() == $("#champTxtVille").val().toUpperCase()){
                $(".descVille",$(this)).slideDown(0);
            }
            else{
                $(this).slideUp(0);
            }
        });    
        afficherChoixDate(villeEntree);
        if(reponseVerifVille[1] == false)$("#listeVilles").delay(300).slideDown(300);
        
        
            
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
        $(this).next().slideToggle(300,"swing");
    });


    /**
     * Donne la possibilité d'appuyer sur Entrée pour choisir une ville, plutôt que de devoir cliquer sur le bouton
     */
    $("#champTxtVille").keyup(function(contexte){
        if(contexte.originalEvent.key == "Enter"){
            $("#validerEntreeVille").trigger("click");
        }
    });

    /**
     * Si au moins l'un des input date est rempli, affiche le bouton de validation.
     */
    $(document).on("input",".inputDate",function(){
        $('html, body').animate({scrollTop:$(".inputDate").last().offset().top}, 'slow');
        $("#boutonValiderDates").slideUp(0);
        $(".inputDate").each(function(){
            var date = $(this)[0].value;
            if(date!=""){
                $("#boutonValiderDates").slideDown(0);
            }
        });
       
    });

    /**
     * Si l'un des 2 champs texte "ville" ou "description" sont vides, le bouton pour continuer est désactivé.
     */
    $(".champnomDesc").on("input",function(){
        if($("#champTxtVilleBis").val()!="" && $("#champTxtDescSpectacle").val()!="")$("#groupSelectDates").children().attr("disabled",false);
        else $("#groupSelectDates").children().attr("disabled",true);
    });

    /**
     * Quand on appuie sur le bouton de confirmation, affiche un modal qui résume tout le spectacle qui va être crée :
     * ville, description et dates
     */
    $("#boutonValiderDates").click(function(){
        var tabDatesJS = new Array();
        var tabDatesHTML = "";
        var contenu;
        var i=1;
        var requete = new Object();
        var ville = $("#champTxtVilleBis").val();
        var desc = $("#champTxtDescSpectacle").val();
        var methodeChoix = $("#groupSelectDates").data("current");
       
        $(".inputDate").each(function(flag){
            var date = $(this)[0].value;
            if(date!=""){
                tabDatesJS.push(date);
            }
        });
        
        
        
        tabDatesJS.sort(diffDate);
        tabDatesJS.forEach(element => {
            tabDatesHTML+="<tr><th scope='row'>"+ i++ +"</th><td>"+traduireDate(element)+"</td></tr>";
        });
        contenu = "<h5> Ville :  "+ville
        +"<br>Decription : "+desc
        +"<br>Dates : </h5><table class='table table-hover center'> <thead><tr><th scope='col'>#</th><th scope='col'>Date</th></tr></thead><tbody>"+tabDatesHTML+"</table>";

        requete = {
            method:"POST",
            url:"./minControleur/dataSpectacle.php",
            data:{
                "action":"ajouterDates",
                "idSpectacle":$("body").data("idSpectacle"),
                "dates":tabDatesJS,
                "ville":ville,
                "desc":desc
            },
            success:function(oRep){
                console.log("Spectacle Créé");
                $("#modalConfirmerDate").modal('dispose');
                document.location.reload();
            }
        }

        creerModal("modalConfirmerDate","Confirmation de l'ajout des dates",contenu,"Confirmer","btn-outline-success",requete);
        $("#modalConfirmerDate").modal();
    });

    $("#groupSelectDates").click(function(contexte){
        $("#selectionDesDates").empty();
        $("#boutonValiderDates").slideUp(0);
        $(this).data("current",contexte.target.value);
        switch(contexte.target.value){
            case "select1by1":
                $("#selectionDesDates").empty().append(selectDate.clone(1));
                $("#selectionDesDates").append($("<div/>").attr("id","ajouterInputDate").addClass("pointer").html("<i style='margin:5px;' class='fas fa-plus'></i>").click(function(){
                    
                    $(this).before(selectDate.clone(1));
                    $('html, body').animate({
                        scrollTop:$(this).offset().top
                    }, 'slow');
                }));
            break;
            case "selectPas":
                /**
                 * On veut sélectionner, par exemple, tous les vendredi pendant 2 mois.
                 * On sélectionne le 1er vendredi, le dernier vendredi, et on met un pas de 7.
                 */
                $("#selectionDesDates").append(
                    $("<span/>").html("Date de début").append(
                        $("<input/>").attr("type","date").attr("id","dateDebutPas").addClass("inputDatePas inputPas")
                    )
                );
                $("#selectionDesDates").append(
                    $("<span/>").html("Date de fin").append(
                        $("<input/>").attr("type","date").attr("id","dateFinPas").addClass("inputDatePas inputPas")
                    )
                );
                $("#selectionDesDates").append(
                    $("<span/>").html("Pas (ex: pas de 3 : sélectionne tous les 3 jours de 'Date de début' à 'Date de fin')").append("<br/>").append(
                        $("<input/>").attr({"type":"number","id":"pas","min":1,"max":14,"value":7}).addClass("inputPas")
                    )
                );
            break;
            case "selectPlage":
            break;
        }
        $('html, body').animate({scrollTop:$("#selectionDesDates").offset().top}, 'slow');
    });

    $(document).on("change",".inputPas",function(){
        var verif=0;
        $(".inputPas").each(function(){
            if($(this).val()=="")verif++;
        });
        $("#boutonValiderDates").slideUp(0);
        $(".boutonCalculerDates").remove();
        $(".inputDate").remove();
        if(verif == 0){
            //Si tous les champs sont remplis
            var dateDebut = $("#dateDebutPas").val();
            var dateFin =  $("#dateFinPas").val();
            var pas = $("#pas").val();
            var erreurDates="";
            var verif = 0;
            
            if(diffDate(dateDebut,dateFin)>=0){
                erreurDates = $("<div/>").addClass("alert alert-danger alerteErreurDates").css("margin-top","10px")
                .html("La <B>date de fin</B> doit être <B>strictement supérieure</B> à la <B>date de début</B> ! ");
                if($(".alerteErreurDates").length == 0)$("#selectionDesDates").append(erreurDates); 
                $('html, body').animate({scrollTop:$("#selectionDesDates").offset().top}, 'slow');
                verif++;
            }
            else $(".alerteErreurDates").remove();

            if(pas<1 || pas >14){
                erreurPas = $("<div/>").addClass("alert alert-danger alerteErreurPas").css("margin-top","10px")
                .html("Le <B>pas</B> doit être compris entre <B>1 et 14</B> ! ");
                if($(".alerteErreurPas").length == 0)$("#selectionDesDates").append(erreurPas); 
                $('html, body').animate({scrollTop:$("#selectionDesDates").offset().top}, 'slow');
                verif++;
            }
            else $(".alerteErreurPas").remove();

            if(verif == 0){
                //Si aucune erreur dans le choix des dates et du pas...
                //On affiche un bouton qui va lancer les calculs.
                /* date = moment();
                date = assignerDateMoment(dateDebut,date); */
                $("#selectionDesDates").append($("<br/>"));
                $("#selectionDesDates").append($("<button/>").addClass("btn btn-outline-primary boutonCalculerDates").html("Calculer les dates").attr("type","button")
                .click(function(){
                    $("#boutonValiderDates").slideUp(0);
                    $(".inputDate").remove();
                    momentDebut = moment($("#dateDebutPas")[0]["valueAsDate"]);
                    momentDebutSave = moment($("#dateDebutPas")[0]["valueAsDate"]);
                    momentFin = moment($("#dateFinPas")[0]["valueAsDate"]);

                    diff = momentFin.diff(momentDebut,'days');
                    nbJours = Math.floor((diff/pas));
                    currDate = selectDate.clone(1).val(momentDebut.format("YYYY-MM-DD"));
                    $("#selectionDesDates").append($(currDate));

                    for(var i=0;i<nbJours;i++){
                        momentDebut.add(pas,'days');
                        currDate = selectDate.clone(1).val(momentDebut.format("YYYY-MM-DD"));
                        $("#selectionDesDates").append($(currDate));
                        
                    }
                    $('html, body').animate({scrollTop:$("#selectionDesDates").offset().top}, 'slow');
                    $("#boutonValiderDates").slideDown(0);
                }));

            }

        }
        
    });

});