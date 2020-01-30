<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

// Chargement eventuel des données en cookies
$email = valider("email", "COOKIE");
$passe = valider("passe", "COOKIE"); 
if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 
else $checked="";

?>


<div id='mainConnexion'>
  <div class="page-header">
    <h1 class="text-center">Connexion</h1>
  </div>
  <div class="jumbotron">
      <div class="form-group row">
          
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10" id='containerMail'>
            <input type="email" class="form-control" id="email" placeholder="Saisir votre email" value="<?php echo $email;?>">
            <div id="verifMail" class='text-danger'></div>
          </div>
          
        </div>
      <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Passe</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPassword" placeholder="Saisir votre mot de passe" value="<?php echo $passe;?>">
        </div>
      </div>
      <div class="custom-control custom-checkbox my-1 mr-sm-2" id='divCheck'>
        <input type="checkbox" class='custom-control-input' name="remember" id="check" <?php echo $checked;?> >
        <label class="custom-control-label" for="check">Se souvenir de moi</label>
      </div>
      <div class='submit'>
        <input type="submit" name="action"  value="Connexion" class="btn btn-danger">
      </div>

      <div class='register'>
        <small id='signUp' class='form-text text-muted'>Vous n'avez pas de compte ? Inscrivez-vous ici</small>
      </div>
  </div>
</div>

<!--NOM - PRENOM - MAIL - MDP -->

<div id='mainInscription'>
  <div class="page-header">
    <h1 class="text-center">Inscription</h1>
  </div>
  <div class="jumbotron">
      <div class="form-group row">
          <label for="nom" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="nom" placeholder="Saisir votre nom">
        </div>
      </div>

      <div class="form-group row">
          <label for="prenom" class="col-sm-2 col-form-label">Pr&eacutenom</label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="prenom" placeholder="Saisir votre prenom">
          </div>
      </div>

      <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10" id='containerMailInscription'>
            <input type="email" class="form-control" id="emailInscription" placeholder="Saisir votre email">
            <div id='verifMailInscription' class='text-danger'></div>
          </div>
      </div>

      <div class="form-group row">
        <label for="inputPasswordInscription" class="col-sm-2 col-form-label">Passe</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPasswordInscription" placeholder="Saisir votre mot de passe">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPasswordConfirm" class="col-sm-2 col-form-label">Confirmation</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Confirmer votre mot de passe">
        </div>
      </div>
     
      <div class='submit'>
        <input type="submit" id='inscription' name="action"  value="Inscription" class="btn btn-danger" disabled='disabled'>
      </div>

      <div class='register'>
        <small id='signIn' class='form-text text-muted'>Vous avez d&eacutej&agrave un compte ? Connectez-vous ici</small>
      </div>
  </div>
</div>
