$(".edit").click(function(){
    $collapse=$($(this).attr("href"));
    $roleForm=$("#roleForm");
    if(!$(this).hasClass("editing")) {
        $(this).addClass("editing").removeClass("edit").html("<i class='fas fa-check' style='color:green;'></i>");
        $(this).next().addClass("cancel").removeClass("remove").html("<i class='fas fa-times' style='color:red;'></i>");
        $roleForm.show();
        $("#name").val($collapse.attr("roleName"));
        if($collapse.attr("video")==1) $("#video").attr("checked", true);
        else $("#video").attr("checked", false);
        if($collapse.attr("spectacle")==1) $("#spectacle").attr("checked", true);
        else $("#spectacle").attr("checked", false);
        if($collapse.attr("user")==1) $("#user").attr("checked", true);
        else $("#user").attr("checked", false);
        if($collapse.attr("annonce")==1) $("#annonce").attr("checked", true);
        else $("#annonce").attr("checked", false);
        $collapse.append($roleForm);
        $(".edit").hide();
        $(".remove").hide();
        $(".new").css("color","darkgrey");
        $(".new").css("cursor","not-allowed");
    }
    else {
        $(this).addClass("edit").removeClass("editing").html("<i class='fas fa-pen'></i>");
        $(this).next().addClass("remove").removeClass("cancel").html("<i class='fas fa-trash-alt' style='color:red;'></i>");
        $(".edit").show();
        $(".remove").show();
        $(".new").css("color","black");
        $(".new").css("cursor","pointer");
        /* 
         * 
         *  Insérer ici la fonction pour sauvegarder un role
         * 
         */
    }
    $collapse.collapse('toggle');
})

$(".remove").click(function(){
    if($(this).hasClass("remove")) {
        $("#"+$(this).attr("idRole")).remove();
        /* 
         * 
         *  Insérer ici la fonction pour supprimer un role
         * 
         */
    }
    else {
        $(this).addClass("remove").removeClass("cancel").html("<i class='fas fa-trash-alt' style='color:red;'></i>");
        $(this).prev().addClass("edit").removeClass("editing").html("<i class='fas fa-pen'></i>");
        $($(this).prev().attr("href")).collapse('toggle');
        $(".edit").show();
        $(".remove").show();
        $(".new").css("color","black");
        $(".new").css("cursor","pointer");
    }
})

$(".new").click(function(){
    $collapse=$("#collapseNew");
    $roleForm=$("#roleForm");
    if(!$(this).hasClass("editing")) {
        if(!$(".editing").length) {
            $(this).addClass("editing").removeClass("new").html("<i class='fas fa-check' style='color:green;'></i>");
            $(this).next().html("<i class='fas fa-times' style='color:red;'></i>");
            $roleForm.show();
            $collapse.append($roleForm);
            $(".edit").hide();
            $(".remove").hide();
        }
    }
    else {
        $(this).addClass("new").removeClass("editing").html("<i class='fas fa-plus'></i>");
        $(this).next().html("");
        $(".edit").show();
        $(".remove").show();
        /* 
         * 
         *  Insérer ici la fonction pour créer un role
         * 
         */
    }
    $collapse.collapse('toggle');
})

$(".cancelNew").click(function(){
    $(this).removeClass("cancelNew").html("");
    $(this).prev().addClass("new").removeClass("editing").html("<i class='fas fa-plus'></i>");
    $("#collapseNew").collapse('toggle');
    $(".edit").show();
    $(".remove").show();
})