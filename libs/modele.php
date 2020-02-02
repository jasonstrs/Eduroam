<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");


function listerUtilisateurs($classe = "both")
{
	// NB : la présence du symbole '=' indique la valeur par défaut du paramètre s'il n'est pas fourni
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,connecte,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "select * from users";
	if ($classe == "pr")
		$SQL .= " where premium=1";
	if ($classe == "npr")
		$SQL .= " where premium=0";
	
	// echo $SQL;
	return parcoursRs(SQLSelect($SQL));

}

function createUser($login,$pass){
	$SQL = "INSERT INTO users(pseudo,passe) VALUES('$login','$pass') ";
	SQLUpdate($SQL);
}



function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id FROM users WHERE pseudo='$login' AND passe='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function verifChamp($nomChamp,$valueChamp,$table){
	$SQL = "SELECT $nomChamp FROM $table";
	$reponse = parcoursRS(SQLSelect($SQL));
	foreach($reponse as $champs){
		foreach($champs as $data){
			if($valueChamp == $data)return 0;
		}
	}
	return 1;
}

function isPremium($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT premium FROM users WHERE id='$idUser'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

function isConnecte(){
	if(valider("connecte","SESSION"))return 1;
	return 0;
}

function passerAdmin ($id) {
	$SQL = "UPDATE users SET premium=1 WHERE id='$id'";
	SQLUpdate($SQL);
}

function passerNonAdmin ($id) {
	$SQL = "UPDATE users SET premium=0 WHERE id='$id'";
	SQLUpdate($SQL);
}

function selectVilles(){
	$reponse = array();
	$SQL = "SELECT idSpectacle,ville FROM spectacle";
	$SQL = SQLSelect($SQL);
	$SQL = parcoursRs($SQL);
	foreach($SQL as $ligne){
		$SQLNbInteresses = "SELECT COUNT(*) FROM spectacle_user WHERE idSpectacle=".$ligne['idSpectacle'];
		$SQLNbInteresses = SQLGetChamp($SQLNbInteresses);

		$SQLNbDates = "SELECT Count(*) FROM date_spectacle WHERE idSpectacle=".$ligne['idSpectacle'];
		$SQLNbDates = SQLGetChamp($SQLNbDates);

		array_push($reponse,array($ligne['ville'],$SQLNbDates,$SQLNbInteresses));
	}
	return $reponse;
}


/**
 * Renvoie true si la ville N'EST PAS dans la base de données
 */
function verifVilleNom($nom){
	$SQL = "SELECT COUNT(*) FROM spectacle WHERE ville='$nom'";
	if(SQLGetChamp($SQL) == 0)return true;
	return false;
}

/**
 * Renvoie l'id du spectacle qui a pour ville $nom
 */
function idVilleNom($nom){
	$SQL = "SELECT idSpectacle FROM spectacle WHERE ville='$nom'";
	return SQLGetChamp($SQL);
}

?>
