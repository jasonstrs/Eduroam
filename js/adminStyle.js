var inputBackColor = undefined;
var selectChoixSize = undefined;
var selectChoixRepeat = undefined;

$("#leadAdminStyle").ready(function(){
    
    (function($) {
        var origAppend = $.fn.append;
    
        $.fn.append = function () {
            return origAppend.apply(this, arguments).trigger("append");
        };
    })(jQuery);
    
    /**
     * Quand on charge les valeurs dans les input, certains ne sont pas encore sur la page.
     * Il faut donc sauvegarder leur valeur, et leur affecter dès qu'ils sont ajoutés à la page
     * => on bind une fonction sur l'évènement 'append' dans la div 'selectBackValue', dans laquelle se trouvent tous les input concernés.
     */
    $("#selectBackValues").bind("append", function() {
        var scr = $("#selectChoixRepeat");
        var scs = $("#selectChoixSize");
        var ibc = $("#inputBackColor");

        if(inputBackColor !== undefined && ibc.length != 0){
            ibc.attr("value",inputBackColor);
        }
        if(selectChoixSize !== undefined && scs.length != 0){
            $("#selectChoixSize option[value='"+selectChoixSize+"'").attr("selected",true);
        }
        if(selectChoixRepeat !== undefined && scr.length != 0){
            $("#selectChoixRepeat option[value='"+selectChoixRepeat+"'").attr("selected",true);
        }

    });
    
    
    
    $(document).on("change",".modif",function(){
        var elt = $(this).attr("targetelt");
        var prop = $(this).attr("targetprop");
        var val = $(this).val();

        if(prop == "background-image")val = "url("+val+")";

        if(elt === undefined || prop === undefined)return;
        $(elt).css(prop,val);
    });


    $(".groupSelectBack").click(function(){
        var choix = $(this).attr("value");

        if($("#selectBackValues").data("choix") == choix){
            return;
        }
        else{
            $("#selectBackValues").data("choix","");
            $("#selectBackValues").empty();
        } 

        if(choix == "image"){
            $(".fond").css("background-color","#FFFFFF");
            $(".fond").css("background-image","url(ressources/backImg/backImage)");

            var inputAddImg = $("<input/>").attr(
                {
                    "type":"file",
                    "id":"inputBackImage",
                    "class":"form-control btn btn-outline-primary pointer",
                    "targetProp":"background-image",
                    "targetElt":".fond",
                    "value":"ressources/backImg/backImageTmp",
                    "style":"margin-bottom:10px",
                    "accept":"image/*"
                }
            );

            var jForm = $("<form/>");

            var formInputAddImg = jForm.clone(1).attr({
                "id":"formInputAddFile"
            }).append(inputAddImg.clone(1));

            $("#selectBackValues").data("choix","image").append($("<div/>").html("Importez un nouveau fichier"));                      
            $("#selectBackValues").data("choix","image").append(formInputAddImg.clone(1)); 


            //Lance une fonction AJAX quand on charge un image dans l'input
            $('#inputBackImage').change(function(){
                var formulaire = new FormData();
                formulaire.append("fic",($("#inputBackImage")[0])["files"][0]);
                formulaire.append("action","uploadFondEcran");
                $.ajax({
                    url: 'minControleur/dataStyleAdmin.php', //script qui traitera l'envoi du fichier
                    type: 'POST',
                    //Données du formulaire envoyé
                    data: formulaire,
                    xhr: function() { // xhr qui traite la barre de progression
                        myXhr = $.ajaxSettings.xhr();
                        if(myXhr.upload){ // vérifie si l'upload existe
                            myXhr.upload.addEventListener('#progressUpload',afficherAvancement, false); // Pour ajouter l'évènement progress sur l'upload de fichier
                        }
                        return myXhr;
                    },
                    //Traitements AJAX
                    beforeSend: function(){
                        $("#formInputAddFile").append($("<progress/>").attr({"id":"progressUpload","value":0}).addClass("form-control"));
                    },
                    success: function(rep){
                        if(rep != "1"){
                            console.log(rep);
                           /*  $('#progressUpload').fadeOut(500);
                            var alerteError = alerteB.clone(1).html("Erreur lors de l'upload du fichier : "+rep).addClass("alert alert-danger").append(boutonFermerAlerteB.clone(1));
                            $("#formInputAddFile").append(alerteError.clone(1)); */
                        }
                        window.setTimeout(function(){
                            $('#progressUpload').fadeOut(200,function(){
                                $(this).remove();
                                $(".alert").remove();

                                $("#inputBackImage").attr("disabled",true);

                                var alerteW = alerteB.clone(1).html("Rechargez la page avant d'upload une nouvelle image. Si vous uploadez une nouvelle image, le changement sera bien pris en compte, mais l'aperçu d'exemple ne changera pas").addClass("alert alert-warning").append(boutonFermerAlerteB.clone(1));
                                $("#formInputAddFile").append(alerteW.clone(1));
                                
                                var alerte = alerteB.clone(1).html("Fichier uploadé avec succès").addClass("alert alert-success").append(boutonFermerAlerteB.clone(1));
                                $("#formInputAddFile").append(alerte.clone(1));
                                var inp = $("#inputBackImage");
                                $(inp.attr("targetElt")).css(inp.attr("targetProp"),"url("+inp.attr("value")+")");
                            });
                        },500);
                        
                        
                    },
                    error: function(){
                        window.setTimeout(function(){
                            $('#progressUpload').remove();
                            var alerte = alerteB.clone(1).html("Erreur").addClass("alert alert-success").append(boutonFermerAlerteB.clone(1));
                            $("#formInputAddFile").append(alerte.clone(1));
                        },500);
                    },
                    
                    //Options signifiant à jQuery de ne pas s'occuper du type de données
                    cache: false,
                    contentType: false,
                    processData: false
                });
                });
                function afficherAvancement(e){
                    if(e.lengthComputable){
                        $('#progressUpload').attr({value:e.loaded,max:e.total});
                    }
                }

            
            




            var jSelect = $("<select/>").attr({
                "class":"modif form-control",
                "style":"margin-bottom:20px"
            });      

            var selectRepeat =  jSelect.clone(1).attr({"name":"selectRepeat","id":"selectChoixRepeat","targetProp":"background-repeat","targetElt":".fond"})
                                .append($("<option/>").attr("value","repeat").html("Répétition horizontale & Verticale"))
                                .append($("<option/>").attr("value","no-repeat").html("Pas de répétition du fond d'écran"))
                                .append($("<option/>").attr("value","repeat-y").html("Répétition verticale"))
                                .append($("<option/>").attr("value","repeat-x").html("Répétition horizontale"));
                                

            $("#selectBackValues").data("choix","image").append($("<div/>").html("Répétition du fond d'écran"));                      
            $("#selectBackValues").data("choix","image").append(selectRepeat.clone(1));  


            var selectSize = jSelect.clone(1).attr({"name":"selectSize","id":"selectChoixSize","targetProp":"background-size","targetElt":".fond"})
                                .append($("<option/>").attr("value","initial").html("L'image conserve sa taille initiale."))
                                .append($("<option/>").attr("value","contain").html("L'image est affichée en entier"))
                                .append($("<option/>").attr("value","cover").html("L'image couvre tout l'écran (une partie peut être coupée si l'image et la page n'ont pas les même proportions)"))
                                

            $("#selectBackValues").data("choix","image").append($("<div/>").html("Taille de l'image"));                      
            $("#selectBackValues").data("choix","image").append(selectSize.clone(1));  

        }
        else if(choix == "color"){
            $(".fond").css("background-image","none");
            var inputBackColor = $("<input/>").attr(
                {
                    "type":"color",
                    "id":"inputBackColor",
                    "class":"modif",
                    "targetProp":"background-color",
                    "targetElt":".fond",
                }
            )
            $("#selectBackValues").data("choix","color").append(inputBackColor);
        }
    });

    $("#annulerChange").click(function(){
        window.location.reload();
    });

    $("#validerChange").click(function(){

        var rep = new Array();

        $(".modif").each(function(){
            console.log($(this));
            var id = $(this).attr("id");
            var targetElt = $(this).attr("targetElt");
            var targetProp = $(this).attr("targetProp");
            var value = $(this).val();
            if(value === undefined){
                //Si c'est un select, sa value est undefined, puisque la value est sur l'option selectionnee
                value = $(this)[0].selectedOptions[0].value
            }
            /* console.log(id);
            console.log(targetElt);
            console.log(targetProp);
            console.log(value); */

            var currO = {
                "targetElt":targetElt,
                "targetProp":targetProp,
                "value":value,
                "id":id
            }

            rep.push(currO);
        });

        rep = {
            "background-type":$("#selectBackValues").data("choix"),
            content : rep
        }

        var strRep = JSON.stringify(rep);

        $.ajax({
            url: 'minControleur/dataStyleAdmin.php', //script qui traitera l'envoi du fichier
            type: 'POST',
            dataType:"json",
            data: {
                json : rep,
                action : "validerChange"
            },
            success: function(rep){
                window.location.reload();
            },
            error: function(rep){
                
            }
        })
        
    });

    $("#boutonDefaut").click(function(){
        var oDefaut = {
            "background-type":"color",
            "content":[
                {
                    "targetElt":".fond",
                    "targetProp":"background-color",
                    "value":"#ffffff","id":"inputBackColor"
                },
                {
                    "targetElt":".navbar",
                    "targetProp":"background-color",
                    "value":"#c8912a","id":"backColorHeadFoot"
                },
                {
                    "targetElt":".navbar",
                    "targetProp":"color",
                    "value":"#000000",
                    "id":"colorHeadFoot"
                },
                {
                    "targetElt":".lead",
                    "targetProp":"background-color",
                    "value":"#e9e9e9","id":"backColorLead"
                },
                {
                    "targetElt":".lead",
                    "targetProp":"color",
                    "value":"#000000",
                    "id":"colorLead"
                }
            ]
        };

        $.ajax({
            url: 'minControleur/dataStyleAdmin.php', //script qui traitera l'envoi du fichier
            type: 'POST',
            dataType:"json",
            data: {
                json : oDefaut,
                action : "validerChange"
            },
            success: function(rep){
                window.location.reload();
            },
            error: function(rep){
                
            }
        })



    });

});

