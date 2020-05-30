$("#leadAdminStyle").ready(function(){
    
    
    $(document).on("change",".modif",function(){
        console.log($(this));
        var elt = $(this).attr("targetelt");
        var prop = $(this).attr("targetprop");
        var val = $(this).val();
        if(elt === undefined || prop === undefined)return;
        console.log("cible : "+elt);
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

        }
        else if(choix == "color"){
            var inputBackColor = $("<input/>").attr(
                {
                    "type":"color",
                    "id":"inputBackColor",
                    "class":"modif",
                    "targetProp":"background-color",
                    "targetElt":"body",
                }
            )
            $("#selectBackValues").data("choix","color").append(inputBackColor);
        }
    });
});

