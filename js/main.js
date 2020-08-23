/**
 *                                                      VARIABLES MODIFIABLES
 */

// Widget Discord
var idServeurDiscord = "621357918234869781"; //493014627047702528
var largeurWidgetDiscord = "350px";
var hauteurWidgetDiscord  = "500px";

/**
 *                                                      FIN VARIABLES MODIFIABLES
 */

$(document).ready(function(){
    //console.log("On charge les dates en fr");
    moment.locale("fr");
})


dateDefaut = new Date(Date.UTC(2012, 11, 20, 3, 0, 0));

optionsAffichageDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
//Permet d'afficher la date
//ex : console.log(dateDefaut.toLocaleDateString('fr-FR', optionsAffichageDate));

var loader = $("<img>").attr({"src":"./ressources/loading.gif"}).css({"width":"50px"});


var modal = $("<div/>").addClass("modal fade").attr({"tabindex":"-1","role":"dialog"}).append(
                $("<div/>").addClass('modal-dialog').attr("role","document").append(
                    $("<div/>").addClass("modal-content").append(
                        $("<div/>").addClass("modal-header").append(
                            $("<h5/>").addClass("modal-title")
                        )
                    )
                )
            )


/**
 * Fonction permettant de créer un modal bootstrap
 * /!\ Crée un modal "simple" => Que du texte pour le titre, 1 seul bouton de confirmation et un d'annulation dans le footer
 * Ne pas utiliser cette fonction pour créer des modal plus complexes
 * @param {string} id Permet de donner un id au modal, afin de pouvoir le déclencher avec un bouton
 * <button type="button" class="btn btn-primary" data-toggle="modal" data-target="id">
 * @param {string} titre Titre du modal
 * @param {string} contenu Contenu HTML du corps du modal
 * @param {string} confirmation Texte du bouton de confirmation
 * @param {string} couleur Couleur du bouton de confirmation (en classes bootstrap, ex: btn-warning pour jaune, btn-primary pour bleu,btn-danger pour rouge)
 * @param {object} requete La requete ajax à lancer lors de la confirmation.
 * 
 */
function creerModal(id,titre,contenu,confirmation,couleur,requete){
var modal = $("<div/>").addClass("modal fade").attr({"tabindex":"-1","role":"dialog","id":id,"aria-labelledby":id,"aria-hidden":"true"}).append(
                $("<div/>").addClass('modal-dialog').attr("role","document").append(
                    $("<div/>").addClass("modal-content").append(
                        $("<div/>").addClass("modal-header").append(
                            $("<h5/>").addClass("modal-title").attr("id",id).html(titre)
                        ).append(
                            $("<button/>").addClass("close").attr({"type":"button","data-dismiss":"modal","aria-label":"Close"}).append(
                                $("<span/>").html("&times;").attr("aria-hidden","true")
                            )
                        )
                    ).append(
                        $("<div/>").addClass("modal-body").html(contenu)
                    ).append(
                        $("<div/>").addClass("modal-footer").append(
                            $("<button/>").addClass("btn btn-secondary").attr({"type":"button","data-dismiss":"modal"}).html("Fermer")
                        ).append(
                            $("<button/>").addClass("btn "+couleur).attr({"type":"button"}).html(confirmation).click(function(){
                                $.ajax({
                                    method:requete.method,
                                    url:requete.url,
                                    data:requete.data,
                                    success:requete.success,
                                    error:requete.error
                                })
                            })
                        )
                    
                    )
                )
            ).on("hidden.bs.modal",function(e){
                $(this).remove();
            });

$("body").append(modal);
}


/**
 * Fonction permettant de créer un modal bootstrap pour confirmation
 * /!\ Crée un modal "simple" => Que du texte pour le titre, 1 seul bouton de confirmatio net un d'annulation dans le footer
 * Ne pas utiliser cette fonction pour créer des modal plus complexes
 * @param {string} id Permet de donner un id au modal, afin de pouvoir le déclencher avec un bouton
 * <button type="button" class="btn btn-primary" data-toggle="modal" data-target="id">
 * @param {string} titre Titre du modal
 * @param {string} confirmation Texte du bouton de confirmation
 * @param {string} couleur Couleur du bouton de confirmation (en classes bootstrap, ex: btn-warning pour jaune, btn-primary pour bleu,btn-danger pour rouge)
 * @param {string} type_du_input Type du input mis dans le body du modal
 * @param {string} placeholder Placeholder à saisir dans le input
 * @param {function} function_success Permet de saisir la fonction lorsque l'on clique sur la validation
 * @param {boolean} boolean Permet de savoir si lorsque l'on détruit le popup, on effectue la fonction echec
 */
function creerModalVerif(id,titre,confirmation,couleur,type_du_input,placeholder,function_success,function_echec,boolean){

    var modal = $("<div/>").addClass("modal fade").attr({"tabindex":"-1","role":"dialog","id":id,"aria-labelledby":id,"aria-hidden":"true"}).append(
                    $("<div/>").addClass('modal-dialog').attr("role","document").append(
                        $("<div/>").addClass("modal-content").append(
                            $("<div/>").addClass("modal-header").append(
                                $("<h5/>").addClass("modal-title").attr("id",id).html(titre)
                            ).append(
                                $("<button/>").addClass("close").attr({"type":"button","data-dismiss":"modal","aria-label":"Close"}).append(
                                    $("<span/>").html("&times;").attr("aria-hidden","true")
                                )
                            )
                        ).append(
                            $("<div/>").addClass("modal-body").html('<input type="' + type_du_input+ '" class="form-control" id="verifChamps" placeholder="' + placeholder +'">')
    
                        ).append(
                            $("<div/>").addClass("modal-footer").append(
                                $("<button/>").addClass("btn btn-danger").attr({"type":"button","data-dismiss":"modal"}).html("Fermer")
                            ).append(
                                $("<button/>").addClass("btn "+couleur).attr({"type":"button"}).html(confirmation).click(function(){     
                                    if (function_success($("#verifChamps"))){ // si on a success, on destroy l'ensemble
                                        $(modal).remove();
                                        $(".fade").remove();
                                        
                                        if (boolean)
                                            function_echec();
                                    }
                                })
                            )
                        )
                    )
                ).on("hidden.bs.modal",function(e){
                    $(this).remove();
                    function_echec();
                });
    
    $("body").append(modal);
}


/**
 * Transforme une date informatique (yyyy-mm-dd) au format français (jj/mm/aaaa)
 * @param {string} date 
 */
function traduireDate(date){
    tab = date.split("-");
    //Si la date était déjà au bon format, on la retourne
    if(tab.length == 1)return date;
    ndate=tab[2]+"/"+tab[1]+"/"+tab[0];
    return ndate;
}


/**
 * Fait la différence entre 2 dates au format yyyy-mm-dd
 * 
 * @return <0 si date1 < date2 ; >0 si date 1 > date2 ; 0 si les deux dates sont égales
 * 
 * @param {string} date1 
 * @param {string} date2 
 */
function diffDate(date1,date2){
    var tab1 = date1.split("-");
    var annee1 = tab1[0];
    var mois1 = tab1[1];
    var jour1 = tab1[2];

    var tab2 = date2.split("-");
    var annee2 = tab2[0];
    var mois2 = tab2[1];
    var jour2 = tab2[2];

    if(annee1 != annee2){
        //Si les 2 années sont différentes, on peut déja différencier les dates
        if(annee1 < annee2)return -1;
        else return 1
    }
    else if(mois1 != mois2){
        //Si les années sont identiques, on compare les mois
        if(mois1 < mois2)return -1;
        else return 1;
    }
    else if(jour1 != jour2){
        //Si les mois sont identiques, on compare les jours
        if(jour1 < jour2)return -1;
        else return 1;
    }
    return 0;
}

/**
 * Décompose date et assigne les valeurs au moment
 * @param {string} _date 
 * @param {moment} _moment 
 */
function assignerDateMoment(_date,_moment){
    var tab = _date.split("-");
    console.log(tab);
    _moment.set({"year":parseInt(tab[0]),"month":parseInt(tab[1]-1),"date":parseInt(tab[2])});
    return _moment;
}


function delLineBreak(str){
    str = str.replace("\n","");
    return str.replace("\r","");
}

/**
 * Modele jQuery pour une alerte Bootstrap
 */
var alerteB = $("<div/>").addClass("alert alert-dismissible fade show").attr("role","alert").css({"width":"100%","text-align":"center","margin-top":"20px"});
/**
 * Modele jQuery pour la croix qui ferme une alerte Bootstrap
 */
var boutonFermerAlerteB = $("<button/>").addClass("close").attr({"data-dismiss":"alert","aria-label":"close"}).append($("<span/>").attr("aria-hidden",true).html("&times;"));