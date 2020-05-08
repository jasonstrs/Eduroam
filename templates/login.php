<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}


// Chargement eventuel des données en cookies
//  -> identifiant
//  -> case à cocher
$email = valider("email", "COOKIE");
if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 
else $checked="";
?>


<script src='./js/registerJquery.js'></script>
<link rel="stylesheet" type="text/css" href="./css/register.css">
 
<?php
if (valider("mail","GET")){ // si on clic sur le nouveau mail de confirmation
  if (valider("mail","GET") == "fail"){ // ERREUR
    echo "<div class=\"alert alert-danger\" role=\"alert\" style='text-align:center;'>
      Adresse mail inexistante ou déjà confirmée.
    </div>";
  } else if (valider("mail","GET") == "success"){ // SUCCESS
    echo "<div class=\"alert alert-success\" role=\"alert\" style='text-align:center;'>
         Adresse mail confirmée. Vous pouvez désormais vous connecter !
         </div>";
  }
}

if (valider("pass","GET")){ // si on demande à changer de MDP
  if (valider("pass","GET") == "fail"){ // ERREUR
    echo "<div class=\"alert alert-danger\" role=\"alert\" style='text-align:center;'>
      Lien erroné ou mauvaises données saisies, le mot de passe n'a pas pu être changé.
    </div>";
  } else if (valider("pass","GET") == "success"){ //SUCCES
    echo "<div class=\"alert alert-success\" role=\"alert\" style='text-align:center;'>
         Le mot de passe a été modifié. Vous pouvez désormais vous connecter !
         </div>";
  }
}
?>

<div id="mainLog">

  <div id='mainConnexion'>
    <div class="page-header">
      <h1 class="text-center">Connexion</h1>
    </div>
    <div class="jumbotron">
        <div id="log" class='text-danger'></div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10" id='containerMail'>
              <input type="email" class="form-control" id="email" placeholder="Saisir votre email" value="<?php echo $email;?>">
              <div id="verifMail" class='text-danger'></div>
            </div>
          </div>
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Saisir votre mot de passe" value="">
            <div id="checkPass" class='text-danger'></div>
          </div>
        </div>
        <div class="custom-control custom-checkbox my-1 mr-sm-2" id='divCheck'>
          <input type="checkbox" class='custom-control-input' name="remember" id="check" <?php echo $checked;?> >
          <label class="custom-control-label" for="check">Se souvenir de moi</label>
        </div>
        <div class='submit'>
          <input type="submit" name="action"  value="Connexion" class="btn btn-outline-secondary">
        </div>

        <div class='register'>
          <small id='signUp' class='form-text text-muted clic'>Vous n'avez pas de compte ? Inscrivez-vous ici</small>
          <small id='forgotPass' class='form-text text-muted clic'>Mot de passe oublié ?</small>
        </div>
    </div>
  </div>
  <div id='form'></div>
</div>


  <div class="alert alert-success mt-3" role="alert" style="display:none" id="envoiMail">
  </div>