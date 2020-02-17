<?php


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");


/*



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

function passerAdmin ($id) {
	$SQL = "UPDATE users SET premium=1 WHERE id='$id'";
	SQLUpdate($SQL);
}

function passerNonAdmin ($id) {
	$SQL = "UPDATE users SET premium=0 WHERE id='$id'";
	SQLUpdate($SQL);
}*/

/**
 * Verif si l'utilisateur est dans la BDD 
 */
function verifUserBdd($email,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT idU FROM user WHERE email='$email' AND passe='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

/**
 * Retourne le hash
 */
function hashCode($id)
{
	
	$SQL="SELECT hashCode FROM user WHERE idU='$id'";
	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}



/**
 * Verif si l'utilisateur a confirmé son mail
 * Return 1 si c'est validé
 */
function isConfirm($idUser)
{
	// vérifie si l'utilisateur a validé son mail
	$SQL ="SELECT code FROM user WHERE idU='$idUser'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

/**
 * Verif si l'utilisateur a confirmé son mail
 * Return 1 si c'est validé
 */
function isConfirmViaMail($email)
{
	// vérifie si l'utilisateur a validé son mail
	$SQL ="SELECT code FROM user WHERE email='$email'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}


/**
 * L'utilisateur vient de confirmer son adresse
 */
function confirmAdress ($id) {
	$SQL = "UPDATE user SET code=1 WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * Créer un utilisateur
 */
function createUser($email,$nom,$prenom,$passe,$hashCode){
	$SQL = "INSERT INTO user(email,nom,prenom,passe,superadmin,code,hashCode) VALUES('$email','$nom','$prenom','$passe','0','0','$hashCode') ";
	SQLUpdate($SQL);
}

/**
 * Renvoie true si l'adresse mail est deja dans la BDD
 */
function verifExistMail($email){
	$SQL = "SELECT COUNT(*) FROM user WHERE email='$email'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}


//Charge les spectacles présents dans la BDD
//Renvoie la structure suivante : 
/*id : id du spectacle,
            desc : description du spectacle,
            ville : ville où va avoir lieu le spectacle,
            nbSpecVille : nombre de spectacles pour cette ville
            nbDates : nombre de dates total
            nbInteresses : nombre de personnes interessées
            dates : [
                idSpectacle,
                idDate,
                date,
                nb : nombre de personnes pour cette date
			]
*/
function selectVilles($nom = ""){
	$reponse = array();
	$SQL = "SELECT idSpectacle,ville,description FROM spectacle";
	$SQL = SQLSelect($SQL);
	$SQL = parcoursRs($SQL);
	foreach($SQL as $ligne){
		$SQLNbInteresses = "SELECT COUNT(*) FROM spectacle_user WHERE idSpectacle=".$ligne['idSpectacle'];
		$SQLNbInteresses = SQLGetChamp($SQLNbInteresses);

		$SQLNbSpecVille = "SELECT COUNT(*) FROM spectacle WHERE ville=\"".$ligne['ville']."\"";
		$SQLNbSpecVille = SQLGetChamp($SQLNbSpecVille);

		$SQLGetDates = "SELECT * FROM date_spectacle WHERE idSpectacle=".$ligne['idSpectacle'];
		$SQLGetDates = parcoursRs(SQLSelect($SQLGetDates));

		for( $i=0 ; $i < sizeof($SQLGetDates) ; $i++ ){
			$date = $SQLGetDates[$i];
			$SQLNbPers = "SELECT COUNT(*) FROM spectacle_user WHERE idSpectacle=".$date["idSpectacle"]." AND idDate=".$date["idDate"];
			$SQLGetDates[$i]["nb"] = SQLGetChamp($SQLNbPers);
		}

		$currRep = array(
						"id" => $ligne["idSpectacle"],
						"desc" => $ligne["description"],
						"ville" => $ligne['ville'],
						"nbSpecVille" => $SQLNbSpecVille,
						"nbDates" => sizeof($SQLGetDates),
						"nbInteresses" => $SQLNbInteresses,
						"dates" => $SQLGetDates
				);
		array_push($reponse,$currRep);
	}
	return $reponse;
	$SQL = "SELECT s.idSpectacle AS id,s.ville AS nom,s.description AS _description
	, COUNT(ds.idDate),COUNT(su)";
	
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


function isSuperAdmin($id,$hash){
	return SQLGetChamp("SELECT superadmin FROM user WHERE idU='$id' AND hashCode='$hash'");
}

?>
