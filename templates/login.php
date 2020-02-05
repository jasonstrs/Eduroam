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

<!DOCTYPE html>
<html lang='fr'>
  <head>
    <title>First Page</title>
    <meta charset="utf-8">
  </head>
  <body>

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
        <label for="inputPassword" class="col-sm-2 col-form-label">Passe</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPassword" placeholder="Saisir votre mot de passe" value="<?php echo $passe;?>">
          <div id="checkPass" class='text-danger'></div>
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
        <small id='signUp' class='form-text text-muted clic'>Vous n'avez pas de compte ? Inscrivez-vous ici</small>
        <small id='forgotPass' class='form-text text-muted clic'>Mot de passe oublié ?</small>
      </div>
  </div>
</div>

<!--NOM - PRENOM - MAIL - MDP -->

<div id='mainInscription'>
  <div class="page-header">
    <h1 class="text-center">Inscription</h1>
  </div>
  <div class="jumbotron" id='blocInscription'>
      <div class="form-group row">
          <label for="nom" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="nom" placeholder="Saisir votre nom">
          <div id='verifNomInscription' class='text-danger'></div>
        </div>
      </div>

      <div class="form-group row">
          <label for="prenom" class="col-sm-2 col-form-label">Prénom</label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="prenom" placeholder="Saisir votre prenom">
          <div id='verifPrenomInscription' class='text-danger'></div>
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
          <div id='verifPasswordInscription' class='text-danger'></div>
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPasswordConfirm" class="col-sm-2 col-form-label">Confirmation</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Confirmer votre mot de passe">
          <div id='verifPasswordConfirmInscription' class='text-danger'></div>
        </div>
      </div>
     
      <div class='submit'>
        <input type="submit" id='inscription' name="action"  value="Inscription" class="btn btn-danger">
      </div>

      <div class='register'>
        <small id='signIn' class='form-text text-muted clic'>Vous avez déjà un compte ? Connectez-vous ici</small>
      </div>
  </div>
</div>

<div class="alert alert-success" role="alert" id="envoiMail">
  <h4 class="alert-heading">Inscription terminée</h4>
  <p>Un email vient de vous être envoyé. Veuillez confirmer votre adresse mail avant de pouvoir vous connecter !</p>
</div>

<div class="form-group row" id='keyPass'>
  <h4>Mot de passe oublié</h4>
  <div class="col-sm-10" id='containerMailInscription'>
    <input type="email" class="form-control" name='email' id="emailRecup" placeholder="Saisir votre email">
    <div id='verifForgetPass' class='text-danger'></div>
    <input type='submit' value='Recevoir' id='receive' class='btn btn-danger'>
  </div>
</div>
</body>
</html>
