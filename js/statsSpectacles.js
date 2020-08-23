function modifLien(id,val,prev){
    console.log(val);
    console.log(prev);
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"modifLien",
            idDate:id,
            valeur:val,
            prev_val : prev
        },
        success:function(oRep){
            var rep = JSON.parse(oRep);
            $(".alert").remove();
            $("#myTabContent").prepend(alerteB.css("margin-top","10px").clone(1).html("Lien modifié : '"+rep["ancien"]+"' -> '"+rep['nouveau']+"'").addClass("alert-success")
            .append(boutonFermerAlerteB));
        },
        error:function(oRep){

        }
    });
}

/**
 * Récupère le nombre de dates
 * valide : 1 -> dates validées
 *          2 -> dates en attente
 */
function nbDates(valide){
    $.ajax({
        method:"POST",
        url:"./minControleur/dataSpectacle.php",
        data:{
            action:"nbDates",
            val:valide,
            tri:$("#selectTri").val()
        },
        success:function(oRep){
            var tab = JSON.parse(oRep);
            var id="#nbDatesEnAttente";
            if(tab.valid == "validees")id="#nbDatesValidees";
            if(tab.valid == "archivees")id="#nbDatesArchivees";
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

            //Id du tableau (change en fonction de valid)
            var id="#collapseOne";
            //Classe du tableau (Les cellules du tableau des dates valides doivent pouvoir être cliquables)
            var classeTab="table table-striped";
            //Actions réalisables sur les dates (Valider/Supprimer pour les non validées, Archiver/Supprimer pour les validées)
            var finTab="<th>Valider</th><th>Supprimer</th>";

            var descTab = "Dates en attente";

            if(tab.valid == "validees"){
                id="#collapseTwo";
                classeTab="table table-hover pointer";
                var finTab="<th>Lien</th><th>Archiver</th><th>Supprimer</th>"
                descTab = "Dates validée";
            }
            else if(tab.valid == "archivees"){
                id="#collapseThree"
                finTab="<th>Supprimer</th>";
                descTab = "Dates archivées";
            }


            if(tab.rep.length == 0 ){
                $(id).html(" <i>Aucune date</i>");
                return;
            }
            /**
             * 
             *                                             CREATION DU TABLEAU
             * 
             */
            var table = $("<table/>").addClass(classeTab).data("descTab",descTab);
            table.append($("<thead/>").html('<tr><th>Description</th><th>Ville</th><th>Date</th><th>Nombre d\'Inscrits</th>'+finTab+'</tr>'));
            var tbody=$("<tbody/>");
            tab["rep"].forEach(element => {
                var currLigne=$("<tr/>").data("datas",element);
                currLigne.data("datas").dateSpectacle = traduireDate(currLigne.data("datas").dateSpectacle);
                if(element.lien != ""){
                    //Si le lien est renseigné, on peut cliquer sur la ligne pour rediriger vers le site de vente.
                    /* currLigne.click(function(){window.open(element.lien,"_blank")}); */
                }
                else element.lien="<i>Pas de lien renseigné</i>";

                currLigne
                .append($("<td/>").html(element.description))
                .append($("<td/>").html(element.ville))
                .append($("<td/>").html(element.dateSpectacle))
                .append($("<td/>").html(element.nbInscrits));
                if(tab.valid == "attente")currLigne.append($("<td/>").addClass("validDateStats").html("<i class='fas fa-check'></i>").data(element).click(function(){
                    /**                                                                                                                             
                     *                                      CREATION DU MODAL DE VALIDATION DE DATE                                                 
                     */
                    var id = "modalValiderDate";
                    var     contenu = "Valider cette date : <B>"+traduireDate($(this).data("dateSpectacle"))+"</B> du spectacle <B>"+$(this).data("description")+"</B> à <B>"+ $(this).data("ville")+"</B> ?<br/>";
                            contenu += "Les gens interessés reçevront un mail leur confirmant la validation.<br><br>";
                            contenu += "Veuillez entrer le lien de la vente de billets : (Modifiable plus tard)<br>";
                            contenu += "<font color='red'>Attention ! Entrer une adresse complète ( http(s)://... ), sinon le lien ne fonctionnera pas !!</font><br>";
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
                                                var rep = JSON.parse(oRep);
                                                $("#modalValiderDate").modal('dispose');
                                                if(rep.success !=0)Cookies.set("success","Date validée, "+rep["nbMails"]+" mails envoyés");
                                                else Cookies.set("error","Erreur lors de la validation de la date");
                                                document.location.reload();
                                            }
                                        })
                                    })
                                )
                            
                            )
                        )
                    ).on("hidden.bs.modal",function(e){
                        $(this).remove();
                    });
                    $("body").append(modal);
                    /**                                                                                                                             
                     *                                      FIN CREATION DU MODAL DE VALIDATION DE DATE                                                 
                     */
                    //Affichage du modal
                    $("#modalValiderDate").modal();
                }));
                else if(tab.valid == "validees"){
                    currLigne.append($("<td/>").addClass("lienModifiable").html(element.lien).data(element));
                    currLigne.append($("<td/>").addClass("archiverDate").html("<i class='fas fa-archive'></i>").data(element).click(function(){
                        /**
                         * 
                         *                                       MODAL ARCHIVER DATE
                         * 
                         */ 
                        requete = {
                            method:"POST",
                            url:"./minControleur/dataSpectacle.php",
                            data:{
                                "action":"archiverDate",
                                "idSpectacle":$(this).data("idSpectacle"),
                                "idDate":$(this).data("idDate"),
                            },
                            success:function(oRep){
    
                                console.log("Date archivée");
                                $("#modalSupprDate").modal('dispose');
                                Cookies.set("success","Date archivée");
                                document.location.reload();
                            }
                        }
                        contenuModal = "Spectacle : <b>"+$(this).data("description")+"</b> à <b>"+$(this).data("ville")+"</b>";
                        contenuModal += "<br>Date : <b>"+traduireDate($(this).data("dateSpectacle"))+"</b>";
                        contenuModal += "<br>Voulez vous <B>archiver cette date</B> ? ";
                        contenuModal += "<br><span style='color:red'><i class='fas fa-exclamation-triangle'></i> Uniquement si le spectacle a vraiment eu lieu. </span>";
    
                        
    
                        creerModal("modalSupprDate","Archiver cette date?",contenuModal,"Archiver","btn btn-outline-warning",requete);
    
                        /**
                         * 
                         *                                        FIN MODAL ARCHIVER DATE
                         * 
                         */
    
                         //Affichage du modal.
    
                        $("#modalSupprDate").modal();
                    }));
                }
                currLigne.append($("<td/>").addClass("suppDateStats").html("<i class='fas fa-trash-alt'></i>").data(element).click(function(){
                    /**
                     * 
                     *                                       MODAL SUPPRIMER DATE
                     * 
                     */ 
                    requete = {
                        method:"POST",
                        url:"./minControleur/dataSpectacle.php",
                        data:{
                            "action":"supprDate",
                            "idSpectacle":$(this).data("idSpectacle"),
                            "idDate":$(this).data("idDate"),
                        },
                        success:function(oRep){

                            console.log("Date supprimée");
                            $("#modalSupprDate").modal('dispose');
                            Cookies.set("success","Date supprimée");
                            document.location.reload();
                        }
                    }
                    contenuModal = "Spectacle : <b>"+$(this).data("description")+"</b> à <b>"+$(this).data("ville")+"</b>";
                    contenuModal += "<br>Date : <b>"+traduireDate($(this).data("dateSpectacle"))+"</b>";
                    contenuModal += "<br>Voulez vous <B>supprimer cette date</B> ? ";

                    

                    creerModal("modalSupprDate","Supprimer cette date?",contenuModal,"Supprimer","btn btn-outline-danger",requete);

                    /**
                     * 
                     *                                        FIN MODAL SUPPRIMER DATE
                     * 
                     */

                     //Affichage du modal.

                    $("#modalSupprDate").modal();
                }));
                
                
                
                tbody.append(currLigne);
            });
            table.append(tbody);
            $(id).empty();
            $(id).append(table)
        },
        error:function(oRep){
            var id="#nbDatesEnAttente";
            if(oRep.valid == "validees")id="#nbDatesValidees"
            $(id).html("Erreur lors du chargement des dates");
        }
    });
}


/**
 * AU CHARGEMENT DE LA PAGE
 */
$("#accordionStats").ready(function(){
    
    nbDates("attente");
    chargerDatesStats("attente");
    nbDates("validees");
    chargerDatesStats("validees");
    nbDates("archivees");
    chargerDatesStats("archivees");
    $("#selectTri").change(function(){
        console.log($(this).val());
        chargerDatesStats("attente");
        chargerDatesStats("validees");
        chargerDatesStats("archivees");
    });


    $(document).on("click",".lienModifiable",function(){
        /* $(this).data("prevVal",$(this).html()); */
        var donnees = $(this).data();
        var valeur = $(this).text();
        if(valeur == "Pas de lien renseigné")valeur="";
        $(this).replaceWith($("<input/>").attr({"type":"text"}).addClass("form form-control inputTextLien").val(valeur).data(donnees).on("keydown",function(contexte){
            var donnees = $(this).data();
            var valeur = $(this).val();
            if(valeur == "")valeur  = "Pas de lien renseigné";
            if(contexte.originalEvent.key == "Enter"){
                var prev = $(this).data("lien");
                $(this).data("lien",valeur);
                $(this).replaceWith($("<td/>").addClass("lienModifiable").html(valeur).data(donnees));
                if(valeur != "Pas de lien renseigné")modifLien(donnees.idDate,valeur,prev);
                
            }
            else if(contexte.originalEvent.key == "Escape"){
                $(this).replaceWith($("<td/>").addClass("lienModifiable").html(donnees.lien).data(donnees));
            }
        }));
    });

    $("#ExportToExcel").click(function(){

        var tables = new Array();

        $("table").each(function(){
            var dates = new Array();
            $("tr",$(this)).each(function(){
                if($(this).data("datas") != undefined)
                    dates.push($(this).data("datas"));
            });
            tables.push({"descTab":$(this).data("descTab"),"dates":dates});
        });

        console.log(tables);
        console.log(JSON.stringify(tables));

        $("#leadStatsSpectacles").append(loader.clone(1).attr("id","loaderExport"));

        $.ajax({
            method:"POST",
            url:"./minControleur/dataSpectacle.php",
            data:{
                action:"exportToExcel",
                tab:JSON.stringify(tables)
            },
            success:function(oRep){

                $("#loaderExport").remove();

                if(oRep == false){
                    $("#leadStatsSpectacles").append(alerteB.clone(1).addClass("alert-danger").html("L'export a échoué, veuillez réessayer plus tard").append(boutonFermerAlerteB));
                    return;
                }
                $("#lienTelechargerExcel").slideUp(200,function(){
                    $(this).remove();
                });
                $("#leadStatsSpectacles").append(
                    $("<a/>").html(
                        "<i class='fas fa-download'></i>Export réussi, cliquez ici pour télécharger"
                    ).attr({
                        "href":oRep,
                        "id":"lienTelechargerExcel"
                    }).css({
                        "display":"block",
                        "text-align":"center"
                    })
                );
                
            },
            error:function(oRep){

            }
        })


    });

});



