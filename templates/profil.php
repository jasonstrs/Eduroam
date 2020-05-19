<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}
?>

<?php
$idUser = valider("idUser","SESSION");
?>
<script>
  sessionStorage.setItem("idU",<?php echo $idUser?>);
</script>

  <script src='./js/profil.js'></script>
  <link rel="stylesheet" type="text/css" href="./css/profil.css">
  
  <div id="mainProfil">
        <h3>Voici votre profil</h3>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputFirstName" class="col-sm-2 col-form-label">Prénom</label>
            <div class="col-sm-10 divForm" id="firstName">
                <input type="text" class="form-control" id="inputFirstName">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10 divForm" id="name">
                <input type="text" class="form-control" id="inputName">
            </div>
        </div>
        <div class="form-group row" id="pass">
            <label for="modifierPass" class="col-sm-2 col-form-label">Mot de passe</label>
            <div class="col-sm-10 divForm">
                <input type="password" class="form-control" id="modifierPass" autocomplete=false>
            </div>
        </div>
        <br/><hr/>
        <div id="separation">Paramètres de Notifications pour les spectacles</div> <br/>

        <div class="form-group row" id="nbJoursMail">
            <label for="choisirNbJours" class="col-sm-2 col-form-label">Espacement des mails</label>
            <div class="col-sm-10">
                <input type="number" min=1 max=14 placeholder="(en jours)" value="<?php echo getNbJoursMail(valider("idUser","SESSION")); ?>" class="form-control" id="choisirNbJours">
            </div>
        </div>
        
  </div>
