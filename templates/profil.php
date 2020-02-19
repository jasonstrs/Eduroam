<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}
?>

<!DOCTYPE html>
<html lang='fr'>
  <script src='./js/profil.js'></script>
  <link rel="stylesheet" type="text/css" href="./css/profil.css">
  <head>
    <title>First Page</title>
    <meta charset="utf-8">
  </head>
  <body>
  <div>
        <h3>Voici votre profil</h3>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputFirstName3" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10 divForm" id="firstName">
                <input type="text" class="form-control" id="inputFirstName3">
            </div>
        </div>
        <div class="form-group row" class='divForm'>
            <label for="inputName3" class="col-sm-2 col-form-label">Prénom</label>
            <div class="col-sm-10 divForm" id="name">
                <input type="text" class="form-control" id="inputName3">
            </div>
        </div>
        <div class="form-group row" id="pass" class='divForm'>
            <label for="inputPassword3" class="col-sm-2 col-form-label">Mot de passe</label>
            <div class="col-sm-10 divForm">
                <input type="password" class="form-control" id="inputPassword3">
            </div>
        </div>
  </div>
  </body>
</html>