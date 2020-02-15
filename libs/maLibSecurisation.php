<?php

include_once "maLibUtils.php";	// Car on utilise la fonction valider()
include_once "modele.php";	// Car on utilise la fonction connecterUtilisateur()

/**
 * @file login.php
 * Fichier contenant des fonctions de vérification de logins
 */

/**
 * Cette fonction vérifie si le login/passe passés en paramètre sont légaux
 * Elle stocke les informations sur la personne dans des variables de session : session_start doit avoir été appelé...
 * Infos à enregistrer : pseudo, idUser, heureConnexion, isAdmin
 * Elle enregistre l'état de la connexion dans une variable de session "connecte" = true
 * @pre login et passe ne doivent pas être vides
 * @param string $login
 * @param string $password
 * @return false ou true ; un effet de bord est la création de variables de session
 */
function verifUser($email,$password,$check)
{
	$id = verifUserBdd($email,$password);

	if (!$id) return "incorrect";
	
	// on regarde désormais s'il y a confirmé son adresse :

	if (isConfirm($id)){ // oui c'est confirmé !
		// Cas succès : on enregistre pseudo, idUser dans les variables de session 
		// il faut appeler session_start ! 

		$_SESSION["email"] = $email;
		$_SESSION["idUser"] = $id;
		$_SESSION["hash"] = hashCode($id);
		$_SESSION["connecte"] = true;
		$_SESSION["heureConnexion"] = date("H:i:s");

		if ($check == "remember") {
			setcookie("email",$email , time()+60*60*24*30);
			setcookie("passe",$password, time()+60*60*24*30);
			setcookie("remember",true, time()+60*60*24*30);
		} else {
			setcookie("email","", time()-3600);
			setcookie("passe","", time()-3600);
			setcookie("remember",false, time()-3600);
		}

		return "success";
	} else { // l'utilisateur n'a pas confirmé son adresse : 
		return "noConfirm";
	}	
}


function newPasse($hashCode){
echo "<form method='POST' action='#' name='form'>";
	echo "<div class=\"jumbotron\">";
    echo "<div class=\"form-group row\">";
    echo    "<label for=\"inputPasswordInscription\" class=\"col-sm-2 col-form-label\">Mot de passe</label>";
    echo    "<div class=\"col-sm-10\">";
	echo     "<input type=\"password\" class=\"form-control\" id=\"inputPasswordInscription\" name=\"newP\" placeholder=\"Saisir votre mot de passe\">";
	echo    "<small id='signIn' class='form-text text-muted'>Le mot de passe doit contenir au minimum 8 caractères dont 1 majuscule, 1 minuscule et 1 chiffre.</small>";
    echo    "</div>";
    echo  "</div>";
	echo	"<div class=\"form-group row\">";
    echo    "<label for=\"inputPasswordConfirm\" class=\"col-sm-2 col-form-label\">Confirmation</label>";
    echo    "<div class=\"col-sm-10\">";
    echo      "<input type=\"password\" class=\"form-control\" id=\"inputPasswordConfirm\" name=\"newPbis\" placeholder=\"Confirmer votre mot de passe\">";
    echo    "</div>";
    echo "</div>";
    echo  "<div class='submit'>";
    echo    "<input type=\"submit\" value=\"Modifier\" class=\"btn btn-danger\">";
    echo  "</div>";
	echo "</div>";
	echo "<input type='hidden' name='form' value='true'>";
echo "</form>";
}




/**
 * Fonction à placer au début de chaque page privée
 * Cette fonction redirige vers la page $urlBad en envoyant un message d'erreur 
	et arrête l'interprétation si l'utilisateur n'est pas connecté
 * Elle ne fait rien si l'utilisateur est connecté, et si $urlGood est faux
 * Elle redirige vers urlGood sinon
 */
function securiser($urlBad,$urlGood=false)
{
	if (! valider("connecte","SESSION")) {
		rediriger($urlBad);
		die("");
	}
	else {
		if ($urlGood)
			rediriger($urlGood);
	}
}

?>

<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="../css/register.css" rel="stylesheet" />
<link href="../css/sticky-footer.css" rel="stylesheet" />
