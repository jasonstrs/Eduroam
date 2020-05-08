<?php
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php?view=accueil");
        die("");
    }

?>
<script src='./js/changePass.js'></script>
<?php

    $flag=0;

    if (isset($_SESSION['hashModifPass'])){
        $hash = $_SESSION['hashModifPass'];
        unset($_SESSION["hashModifPass"]); // on clear la variable
        session_destroy();
        $id = getIdViaHash($hash); // sécurité !

        if ($id){ // s'il y a un id, et donc le hash est correct
            echo "<h3 style='text-align:center;'>Changer votre mot de passe</h3>
                <div class=\"jumbotron container\" id='mainForm'>
                <div class=\"form-group row\">
                <label for=\"inputPassword\" class=\"col-sm-2 col-form-label\">Mot de passe</label>
                <div class=\"col-sm-10\">
                <input type=\"password\" class=\"form-control\" id=\"inputPassword\" name=\"newP\" placeholder=\"Saisir votre mot de passe\">
                <div id='checkPass' class='text-danger'></div>
                </div>
                </div>
                <div class=\"form-group row\">
                <label for=\"inputPasswordConfirm\" class=\"col-sm-2 col-form-label\">Confirmation</label>
                <div class=\"col-sm-10\">
                <input type=\"password\" class=\"form-control\" id=\"inputPasswordConfirm\" name=\"newPbis\" placeholder=\"Confirmer votre mot de passe\">
                <div id='checkPassConfirm' class='text-danger'></div>
                </div>
                </div>
                <div class='submit' style='display:flex;justify-content:center;'>
                <input type=\"submit\" value=\"Modifier\" class=\"btn btn-outline-secondary\" disabled='true'>
                </div>
                </div>
                <input type='hidden' name='hash' value='" . $hash . "'
                ";

        } else // sinon on redirige
            $flag=1;
    } else {
        $flag=1;
    }

    if ($flag) {
        echo "<div class=\"alert alert-danger\" role=\"alert\" style='text-align:center;'>
        Lien erroné, le mot de passe n'a pas pu être changé.
        </div>";
    }



?>




