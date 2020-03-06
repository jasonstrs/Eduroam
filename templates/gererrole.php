<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
}

$search=valider("search","GET");

if (valider("connecte","SESSION") && valider("admin","SESSION")==1) {
?>

<?php } else {
echo "Vous n'avez pas accés à cette page";
} ?>