$(document).ready(function(){
    //Cadre qui assombrit la apge et empeche les clics sur celle-ci
    var blur = $("<div/>").addClass("containerBlur").css("display","none")
        .append($("<div/>").css({"display":"flex","width":"100%","height":"100%","justify-content":"center","align-items":"center"}).addClass("blur"))
        .css({"position":"fixed","background-color":"rgb(0,0,0,0.5)","width":"100vw","height":"100vh","z-index":"999"});

    //Widget permettant de rejoindre facilement le discord
    var widgetDiscord = $("<iframe/>").css({"display":"flex"})
    .attr({"src":"https://discordapp.com/widget?id="+idServeurDiscord+"&theme=dark","width":largeurWidgetDiscord,"height":hauteurWidgetDiscord,"allowtransparency":"true","frameborder":"0"});

    //Croix permettant de revenir à une page normale
    var quitBlur = $("<div/>").addClass("pointer").css({"position":"absolute","color":"white","font-size":"2rem","right":"40px","top":"40px"})
    .click(function(){
        $(".containerBlur").fadeOut(200,function(){
            $(this).remove();
        });
    })
    .append($("<i/>").addClass("fas fa-times "));
    


    $("#btn-Discord").click(function(){
        if($(".containerBlur").length == 0){
            $("body").prepend(blur.clone(1));
            $(".blur").append(widgetDiscord.clone(1));
            $(".blur").append(quitBlur.clone(1));
            $(".containerBlur").fadeIn(200);
        }
        else{
            //Si on a déja un cadre affiché, on le supprime (normalement impossible, sauf si l'utilisateur essaie de faire bugger le site, avec un trigger('click') par exemple)
            $(".containerBlur").fadeOut(200,function(){$(this).remove()});
        }
    });
});

/* <iframe src="https://discordapp.com/widget?id=621357918234869781&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe> */