<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE"); 
if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 

?>



<div class="page-header">
	<h1 class="text-center">Connexion</h1>
</div>


<p class="lead">


 <div class="jumbotron">
 <div class="form-group row">
    <label for="pseudo" class="col-sm-2 col-form-label">Login</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pseudo" placeholder="Saisir votre login" value="<?php echo $login;?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Passe</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Saisir votre mot de passe" value="<?php echo $passe;?>">
    </div>
  </div>
  <div class="checkbox">
    <label><input type="checkbox" name="remember" id="check" <?php echo $checked;?> >Se souvenir de moi</label>
  </div>
  <div class='submit'>
    <input type="submit" name="action"  value="Connexion" class="btn btn-danger">
  </div>

  <div class='register'>
     <small class='form-text text-muted'>Vous n'avez pas de compte ? Inscrivez-vous ici</small>
  </div>
</div>

</p>