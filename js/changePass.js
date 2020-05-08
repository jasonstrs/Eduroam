$(document).on("click","input[value='Modifier']",function(){
    var passe = $("#inputPassword").val();
    var passeConfirm = $("#inputPasswordConfirm").val();
    var hash = $("input[type='hidden']").val();
    

    if (verificationChamps() && passeConfirm == passe){ // petite sécurité
        $("input[value='Modifier']").attr('disabled',true);

        $.ajax({
        type: "POST",
        url: "./minControleur/dataConnexion.php",
        data: {"passe":passe,"hash":hash,"action":'modificationPasse'},
        success: function(oRep){
            console.log(oRep);
            var res;
            switch(oRep) {
                case 'SUCCESS' :
                    res='success';
                break;

                case 'ERROR' :
                    res='fail';
                break;

                default :
                    console.log("Erreur inconnue : Veuillez contacter la maintenance !")
            }

            $(location).attr("href","./index.php?view=login&pass="+res);

        },
        dataType: "text"
        });

    }
});


function verifPasse(){
    var passe = $("#inputPassword").val();
    if (passe == ""){
        $("#inputPassword").removeClass('is-invalid is-valid');
        $("#checkPass").hide();
        return 0;
    }
    
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/.test(passe))){
        $("#checkPass").show();
        $('#checkPass').html('Veuillez saisir un mot de passe valide (8 caractères minimum dont 1 majuscule, 1 minuscule et 1 chiffre)');
        $("#inputPassword").addClass('is-invalid');
        return 0;
    }
    $("#inputPassword").addClass('is-valid').removeClass('is-invalid');
    $("#checkPass").hide();
    return 1;
}

function verifConfirmationPasse(){
    var passe = $("#inputPassword").val();
    var confirmMDP =$("#inputPasswordConfirm").val();

    if (confirmMDP == ""){
        $("#inputPasswordConfirm").removeClass('is-invalid is-valid');
        $("#checkPassConfirm").hide();
        return 0;
    }

    if (passe != confirmMDP){
        $("#checkPassConfirm").show();
        $("#checkPassConfirm").html("Veuillez saisir un mot de passe identique.");
        $("#inputPasswordConfirm").addClass('is-invalid');
        return 0;
    }
    $("#inputPasswordConfirm").addClass('is-valid').removeClass('is-invalid');
    $("#checkPassConfirm").hide();
    return 1;
}

$(document).on('keyup','#mainForm :input',function(){
    var flag = verificationChamps();
    if (!flag)
        $("input[value='Modifier']").attr('disabled',true);
});

function verificationChamps(){
    var flag=1;

    flag = verifPasse()&&flag;
    flag= verifConfirmationPasse()&&flag;

    if (flag){
        $("input[value='Modifier']").attr('disabled',false);
        return 1;
    }
    return 0;
}