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
 * /!\ Crée un modal "simple" => Que du texte pour le titre, 1 seul bouton de confirmatio net un d'annulation dans le footer
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
    console.log(requete);
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
                console.log("On supprime le modal");
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
 * @param {function} fonction_success Permet de saisir la fonction lorsque l'on clique sur la validation
 */
function creerModalVerif(id,titre,confirmation,couleur,type_du_input,placeholder,fonction_success){

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
                            $("<div/>").addClass("modal-body").html('<input type="' + type_du_input+ '" class="form-control" id="verif_pass_modal" placeholder="' + placeholder +'">')
    
                        ).append(
                            $("<div/>").addClass("modal-footer").append(
                                $("<button/>").addClass("btn btn-danger").attr({"type":"button","data-dismiss":"modal"}).html("Fermer")
                            ).append(
                                $("<button/>").addClass("btn "+couleur).attr({"type":"button"}).html(confirmation).click(function(){
                                    // lancer la verif de MDP
                                    // fonction_success
                                })
                            )
                        
                        )
                    )
                ).on("hidden.bs.modal",function(e){
                    console.log("On supprime le modal");
                    $(this).remove();
                });
    
    $("body").append(modal);
    }