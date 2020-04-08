<?php

    $flag=0;

    if (isset($_SESSION['hashModifPass'])){
        $hash = $_SESSION['hashModifPass'];
        unset($_SESSION["hashModifPass"]); // on clear la variable
        session_destroy();
        $id = getIdViaHash($hash); // sécurité !

        if ($id){ // s'il y a un id, et donc le hash est correct
            echo "<h3 style='text-align:center;'>Changer votre mot de passe</h3>";
            echo "<div class=\"jumbotron container\" id='mainForm'>";
            echo 	"<div class=\"form-group row\">";
            echo    "<label for=\"inputPassword\" class=\"col-sm-2 col-form-label\">Mot de passe</label>";
            echo    "<div class=\"col-sm-10\">";
            echo     "<input type=\"password\" class=\"form-control\" id=\"inputPassword\" name=\"newP\" placeholder=\"Saisir votre mot de passe\">";
            echo    "<div id='checkPass' class='text-danger'></div>";
            echo    "</div>";
            echo    "</div>";
            echo	"<div class=\"form-group row\">";
            echo    "<label for=\"inputPasswordConfirm\" class=\"col-sm-2 col-form-label\">Confirmation</label>";
            echo    "<div class=\"col-sm-10\">";
            echo      "<input type=\"password\" class=\"form-control\" id=\"inputPasswordConfirm\" name=\"newPbis\" placeholder=\"Confirmer votre mot de passe\">";
            echo "<div id='checkPassConfirm' class='text-danger'></div>";
            echo    "</div>";
            echo 	"</div>";
            echo  "<div class='submit' style='display:flex;justify-content:center;'>";
            echo    "<input type=\"submit\" value=\"Modifier\" class=\"btn btn-outline-secondary\" disabled='true'>";
            echo  "</div>";
            echo "</div>";

        } else // sinon on redirige
            $flag=1;
    } else {
        $flag=1;
    }

    //if ($flag)
     // header("Location:../index.php?view=accueil");

?>

<script>
$(document).on("click","input[value='Modifier']",function(){
    var passe = $("#inputPassword").val();
    var passeConfirm = $("#inputPasswordConfirm").val();
    var hash = <?php echo json_encode($hash); ?>; // convertir PHP => JS

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
</script>



