<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
} 
if(valider("view","GET")=="role") {
?>
Vous n'avez pas accés à cette page
<?php } else { ?>

    <div>
        <div class="row">
            <div class="col-6">
                Nom du rôle
                <svg class="bi bi-alert-triangle text-success" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"></svg>
            </div>
            <div class="col-6">
            <svg class="bi bi-alert-triangle text-success" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"></svg>
            </div>      
        </div>
    </div>





<?php } ?>