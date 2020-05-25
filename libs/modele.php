<?php

// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");

/**
 * Verif si l'utilisateur est dans la BDD 
 */
function verifUserBdd($email,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT idU FROM eduroam_user WHERE email='$email' AND passe='$passe'";

	return SQLGetChamp($SQL);
}

/**
 * Retourne le hash
 */
function hashCode($id)
{
	
	$SQL="SELECT hashCode FROM eduroam_user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

function isSuperAdmin($id,$hash){
	return SQLGetChamp("SELECT superadmin FROM eduroam_user WHERE idU='$id' AND hashCode='$hash'");
}



function getPrenom($id)
{
	
	$SQL="SELECT prenom FROM eduroam_user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

function getChoice($id) {
	$SQL="SELECT choice FROM eduroam_user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

function getNom($id)
{
	$SQL="SELECT nom FROM eduroam_user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

/**
 * Récupère l'id d'un utilisateur grâce à son hash code
 *
 * @param string $hash
 * @return int l'id de l'utilisateur
 */
function getIdViaHash($hash)
{
	
	$SQL="SELECT idU FROM eduroam_user WHERE hashCode='$hash'";
	return SQLGetChamp($SQL);
}


/**
 * Récupère l'id de l'utilisateur grâce à son email
 *
 * @param string $email
 * @return int l'id de l'utilisateur
 */
function getIdViaMail($email)
{
	
	$SQL="SELECT idU FROM eduroam_user WHERE email='$email'";
	return SQLGetChamp($SQL);
}

/**
 * Verifie si l'utilisateur a confirmé son mail (même fonction que isConfirm(), mais en passant par le mail)
 *
 * @param int $idUser l'Id de l'utilisateur
 * @return boolean 1 si la modification a eu lieu, 0 sinon
 */
function isConfirm($idUser)
{
	$SQL ="SELECT code FROM eduroam_user WHERE idU='$idUser'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}


/**
 * Verifie si l'utilisateur a confirmé son mail (même fonction que isConfirm(), mais en passant par le mail)
 *
 * @param string $email
 * @return boolean 1 si la modification a eu lieu, 0 sinon
 */
function isConfirmViaMail($email)
{

	$SQL ="SELECT code FROM eduroam_user WHERE email='$email'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

/**
 * Change le mot de passe d'un utilisateur
 *
 * @param int $id
 * @param string $newPasse Nouveau mot de passe (déja hashé)
 * @return int||false 1 si le mot de passe a été modifié, 0 sinon, false si erreur
 */
function changePass ($id,$newPasse) {
	$SQL = "UPDATE eduroam_user SET passe='$newPasse' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * Change le nom d'un utilisateur
 *
 * @param int $id
 * @param boolean $choice 1 si l'utilisateur veut recevoir des notifs, 0 sinon
 * @return int||false 1 si le choix a été modifié, 0 sinon, false si erreur
 */
function changeValue ($id,$choice) {
	$SQL = "UPDATE eduroam_user SET choice='$choice' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * Change le prénom d'un utilisateur
 *
 * @param int $id
 * @param string $new Nouveau prénom
 * @return int||false 1 si le prénom a été modifié, 0 sinon, false si erreur
 */
function changeFirstName ($id,$new) {
	$SQL = "UPDATE eduroam_user SET prenom='$new' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * Change le nom d'un utilisateur
 *
 * @param int $id
 * @param string $new Nouveau nom
 * @return int||false 1 si le nom a été modifié, 0 sinon, false si erreur
 */
function changeName ($id,$new) {
	$SQL = "UPDATE eduroam_user SET nom='$new' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * Modifie le hash d'un utilisateur
 *
 * @param string $oldHash
 * @param int $id
 * @param string $newHash
 * @return int||false 1 si le hash a été modifié, 0 sinon, false si erreur
 */
function changeHash($oldHash,$id,$newHash){
	$SQL="UPDATE eduroam_user SET hashCode='$newHash' WHERE hashCode='$oldHash' AND idU='$id'";
	SQLUpdate($SQL);
}
	
/**
 * Confirme l'adresse mail de l'utilisateur
 *
 * @param int $id l'Id de l'utilisateur
 * @return int||false 1 si l'utilisateur a été vérifié, 0 sinon, false si erreur
 */
function confirmAdress ($id) {
	$SQL = "UPDATE eduroam_user SET code=1 WHERE idU='$id'";
	SQLUpdate($SQL);
}


/**
 * Créer un utilisateur
 *
 * @param string $email
 * @param string $nom
 * @param string $prenom
 * @param strng $passe
 * @param string $hashCode
 * @return int||false 1 si l'utilisateur a été crée, 0 sinon, false si erreur
 */
function createUser($email,$nom,$prenom,$passe,$hashCode){
	$SQL = "INSERT INTO eduroam_user(email,nom,prenom,passe,superadmin,code,hashCode) VALUES('$email','$nom','$prenom','$passe','0','0','$hashCode') ";
	SQLUpdate($SQL);
}

/**
 * Renvoie true si l'adresse mail est deja dans la BDD
 *
 * @param string $email Mail de l'utilisateur
 * @return 1 si l'utilisateur est déja dans la BDD, 0 sinon
 */

function verifExistMail($email){
	$SQL = "SELECT COUNT(*) FROM eduroam_user WHERE email='$email'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

/**
 * Vérifie si l'utilisateur accepte de recevoir des mails
 *
 * @param int $idU Id de l'utilisateur
 * @return 1 si l'utilisateur accepte de recevoir des mails, 0 sinon
 */
function getNotifUser($idU){
	$SQL = "SELECT choice FROM eduroam_user WHERE idU='$idU'";
	return(SQLGetChamp($SQL));
}


/**
 * Récupère le nombre de jours entre chaque mail défini par l'utilisateur
 *
 * @param int $idU Id de l'utilisateur
 * @return void
 */
function getNbJoursMail($idU){
	$SQL = "SELECT nbJoursMail FROM eduroam_user WHERE idU='$idU'";
	return(SQLGetChamp($SQL));
}

/**
 * Modifie le nombre de jours entre chaque mail de l'utilisateur
 *
 * @param int $val Le nombre de jours choisi par l'utilisateur
 * @param int $idU l'Id de l'utilisateur
 * @return int||false Le nombre de champs modifiés ou false si pb
 */
function modifNbJoursMail($val,$idU){
	if($val>14 || $val<1)return false;
	$SQL = "UPDATE eduroam_user SET nbJoursMail='$val' WHERE idU='$idU'";
	return SQLUpdate($SQL);
}


/**
 * Récupère la date du dernier mail envoyé à cet utilisateur
 *
 * @param int $idU Id de l'utilisateur
 * @return dateTime date au format yyyy-mm-dd
 */
function  getLastMail($idU){
	$SQL = "SELECT lastMail FROM eduroam_user WHERE idU='$idU'";
	return SQLGetChamp(($SQL));
}


/**
 * Vérifie si il n'est pas trop tôt pour envoyer un mail à l'utilisateur
 * en fonction du nombre de jours à attendre entre chaque mail, défini par l'utilisateur.
 *
 * @param int $id Id de l'utilisateur
 * @return 1 si on peut lui envoyer un mail, 0 sinon
 */
function mailPossible($id){
	if(getLastMail($id) == NULL)return 1;

	$nbJours = getNbJoursMail($id);
	$lastMail = date_create(getLastMail($id));
	$now = date_create(date("Y-m-d"));
	$nextMail = date_add($lastMail,date_interval_create_from_date_string($nbJours." days"));

/* 	die(tprint(array($nbJours,$lastMail,$now,$nextMail,$now < $nextMail)));
 */
	//On fait la différence entre la date actuelle et la date à laquelle on pourra envoyer un mail.
	//Donc si la différence est négative, on ne peut pas encore envoyer de mail.
	if($now < $nextMail) return 0;
	else return 1;
}
/**
 * Modifie le champ lastMail avec la date du jour.
 *
 * @param [string] $to email de l'utilisateur
 * @param [dateTime] $now date du jour au format yyyy-mm-dd
 * @return [int] Nombre de modifs (1 si tout s'est bien déroulé)
 */
function setLastMail($to,$now){
	$SQL = "UPDATE eduroam_user SET lastMail='$now' WHERE email='$to'";
	return SQLUpdate($SQL);
}

/**
 * 
 * 			FONCTIONS POUR LES SPECTACLES
 * 
 */



//Charge les spectacles présents dans la BDD
//Renvoie la structure suivante : 
/*			id : id du spectacle,
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
/**
 * Charge les spectacles présents dans la BDD
 *
 * Renvoie la structure suivante : 
 *			 {id : id du spectacle,
 *           desc : description du spectacle,
 *           ville : ville où va avoir lieu le spectacle,
 *           nbSpecVille : nombre de spectacles pour cette ville,
 *           nbDates : nombre de dates total,
 *           nbInteresses : nombre de personnes interessées,
 *           dates : [
 *               idSpectacle,
 *               idDate,
 *               date,
 *               nb : nombre de personnes pour cette date
 *			]}
 * 
 * @return JSON
 */
function selectVilles(){
	$reponse = array();
	$SQL = "SELECT idSpectacle,ville,description FROM eduroam_spectacle";
	$SQL = SQLSelect($SQL);
	$SQL = parcoursRs($SQL);
	foreach($SQL as $ligne){
		$SQLNbInteresses = "SELECT COUNT(*) FROM eduroam_spectacle_user su,eduroam_date_spectacle ds WHERE ds.idSpectacle=".$ligne['idSpectacle']." AND ds.idDate=su.idDate";
		$SQLNbInteresses = SQLGetChamp($SQLNbInteresses);

		$SQLNbSpecVille = "SELECT COUNT(*) FROM eduroam_spectacle WHERE ville=\"".$ligne['ville']."\"";
		$SQLNbSpecVille = SQLGetChamp($SQLNbSpecVille);

		$SQLGetDates = "SELECT * FROM eduroam_date_spectacle WHERE idSpectacle=".$ligne['idSpectacle']." AND valide='0' ORDER BY dateSpectacle";
		$SQLGetDates = parcoursRs(SQLSelect($SQLGetDates));

		for( $i=0 ; $i < sizeof($SQLGetDates) ; $i++ ){
			$date = $SQLGetDates[$i];
			$SQLNbPers = "SELECT COUNT(*) FROM eduroam_spectacle_user su,eduroam_date_spectacle ds WHERE ds.idSpectacle=".$date["idSpectacle"]." AND su.idDate=".$date["idDate"]." AND ds.idDate=su.idDate";
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
	
}

/**
 * Vérifie si la ville est déja dans la base de donnéees
 *
 * @param string $nom Nom de la ville
 * @return boolean true si la ville n'est pas encore dans la base de données, false sinon
 */
function verifVilleNom($nom){
	$SQL = "SELECT COUNT(*) FROM eduroam_spectacle WHERE ville='$nom'";
	if(SQLGetChamp($SQL) == 0)return true;
	return false;
}


/**
 * Crée un spectacle
 *
 * @param string $ville
 * @param string $description
 * @return int l'id du spectacle
 */
function creerSpectacle($ville,$description){
	$SQL = "INSERT INTO eduroam_spectacle (ville,description) VALUES ('$ville','$description')";
	return SQLInsert($SQL);
}

/**
 * Ajoute une date à un spectacle
 *
 * @param int $id Id du spectacle
 * @param date $date Date à ajouter (format yyyy-mm-dd)
 * @return int l'Id de la date ajoutée
 */
function ajouterDateSpectacle($id,$date){
	$SQL = "INSERT INTO eduroam_date_spectacle (idSpectacle,dateSpectacle) VALUES ($id,'$date')";
	return SQLInsert($SQL);
}

/**
 * Supprime une date
 *
 * @param int $idDate Id de la date
 * @return boolean 1 si la suppression a eu lieu, 0 sinon, false si problème
 */
function supprimerDate($idDate){
	$SQL = "DELETE FROM eduroam_date_spectacle WHERE idDate = $idDate";
	return SQLDelete($SQL);
}

/**
 * Archive une date
 *
 * @param int $idDate Id de la date
 * @return boolean 1 si l'archivage a eu lieu, 0 sinon, false si problème
 */
function archiverDate($idDate){
	$SQL = "UPDATE eduroam_date_spectacle SET valide=2 WHERE idDate = $idDate";
	return SQLUpdate($SQL);
}

/**
 * Supprime un spectacle
 * Si aucune date archivée, on supprimer juste le spectacle
 * Si des dates sont archivées, on supprime toutes les autres
 *
 * @param int $id Id du spectacle
 * @return int 0 ou false si erreur, 1 si le spectacle a été supprimé, 2 si ses dates non archivées ont été supprimées
 */
function supprimerSpectacle($id){
	$rep = 0;
	if(SQLGetChamp("SELECT COUNT(*) FROM eduroam_date_spectacle WHERE valide=2 AND idSpectacle='$id'") == 0){
		//Aucune date de ce spectacle n'est archivée : on peut le supprimer
		$SQL = "DELETE FROM eduroam_spectacle WHERE idSpectacle = $id";
		$rep = 1;
	}
	else{
		//Des dates sont archivées. On supprime juste les dates non archivées
		$SQL = "DELETE FROM eduroam_date_spectacle WHERE idSpectacle='$id' AND valide=0 OR valide=1";
		$rep = 2;
	}
	
	SQLDelete($SQL);
	return $rep;
}

/**
 * Valide une date
 *
 * @param int $id
 * @param string $lien Lien du site de vente de billets
 * @return boolean 1 si la validation a eu lieu, 0 sinon, false si problème
 */
function validerDate($id,$lien){
	$SQL = "UPDATE eduroam_date_spectacle SET valide='1',lien='$lien' WHERE idDate='$id'";
	return SQLUpdate($SQL);
}

/**
 * Compte le nombre de dates dans un certain contexte, passé en paramètre
 *
 * @param string $valid Contexte dans lequel on veut compter les dates
 * @return int Le nombre de dates voulu
 */
function nbDates($valid){
	
	switch($valid){
		case "attente":
			$valid=0;
		break;
		case "validees":
			$valid=1;
		break;
		case "archivees":
			$valid=2;
		break;
		default:
			return json_encode(array("success" => 0));
		break;
	}
	$SQL="SELECT COUNT(*) FROM eduroam_date_spectacle WHERE valide=$valid";
	return SQLGetChamp($SQL);
}

/**
 * Charge les dates dans un contexte voulu
 *
 * @param string $valid Contexte
 * @param string $tri Ordre de tri
 * @param int $id Id de l'utilisateur
 * @param string $ville
 * @return Array Les dates voulues
 */
function chargerDates($valid,$tri,$id,$ville){

	if($ville != "")$ville = "AND s.ville LIKE '$ville'";

	$order="ORDER BY ";
	switch($tri){
		case "nbInscrits":
			$order="";
		break;
		case "date":
			$order.="d.dateSpectacle";
		break;
		case "ville":
			$order.="s.ville";
		break;
		case "spectacle":
			$order.="s.description";
		break;
		default:
			$order="";
		break;
	}

	if($id == false){
		//On veut toutes les dates
		switch($valid){
			case "validees":
				$SQL = "SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d WHERE d.idSpectacle = s.idSpectacle AND d.valide=1 $ville $order";
			break;
			case "attente":
				$SQL = "SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d WHERE d.idSpectacle = s.idSpectacle AND d.valide=0 $ville $order";
			break;
			case "archivees":
				$SQL = "SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d WHERE d.idSpectacle = s.idSpectacle AND d.valide=2 $ville $order";
			break;
		}
	}
	else{
		//On veut les dates en fonction de l'utilisateur
		switch($valid){
			case "validees":
				//Dates validées
				$SQL="SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d WHERE d.idSpectacle = s.idSpectacle AND  d.valide=1 $ville 
				AND d.idDate NOT IN (SELECT su.idDate FROM eduroam_spectacle_user su,eduroam_date_spectacle d WHERE idU = $id AND d.idDate = su.idDate AND d.valide=1) 
				$order";

			break;

			case "attente":
				//Dates en attente
				$SQL="SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d WHERE d.idSpectacle = s.idSpectacle AND d.valide=0 $ville
				AND d.idDate NOT IN (SELECT su.idDate FROM eduroam_spectacle_user su,eduroam_date_spectacle d WHERE idU = $id AND d.idDate = su.idDate AND d.valide=0) 
				$order";
			break;

			case "mesValidees":
				//Vos dates validées
				$SQL="SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d, eduroam_spectacle_user su WHERE su.idU=$id $ville AND su.idDate=d.idDate AND d.idSpectacle = s.idSpectacle AND d.valide=1 $order";
			break;

			case "mesAttentes":
				//Vos dates en attente
				$SQL="SELECT d.idSpectacle,d.idDate,d.dateSpectacle,d.lien,s.description,s.ville 
				FROM eduroam_spectacle s, eduroam_date_spectacle d, eduroam_spectacle_user su WHERE su.idU=$id $ville AND su.idDate=d.idDate AND d.idSpectacle = s.idSpectacle AND d.valide=0 $order";
			break;
		}
	}
	return parcoursRs(SQLSelect($SQL));
}

/**
 * Récupère le nombre d'inscrits pour une date
 *
 * @param int $idDate
 * @return int Le nombre d'inscrits
 */
function nbInscritsDate($idDate){
	$SQL="SELECT COUNT(*) FROM eduroam_spectacle_user WHERE idDate='$idDate'";
	return SQLGetChamp($SQL);
}

/**
 * Récupère le nombre de dates en fonction du contexte passé, et de l'utilisateur courant
 *
 * @param string $choix Contexte
 * @param int $id Id de l'utilisateur
 * @param string $ville On peut préciser une ville si besoin
 * @return int Le nombre de dates
 */
function nbDatesUser($choix,$id,$ville){
	if($ville != "")$ville = "AND s.ville = '$ville'";
	switch($choix){
		case "validees":
			//Dates validées
			$SQL="SELECT COUNT(*) FROM `eduroam_date_spectacle` d,eduroam_spectacle s WHERE d.idSpectacle = s.idSpectacle AND valide = 1 AND d.idDate NOT IN 
			(SELECT su.idDate FROM eduroam_spectacle_user su,eduroam_date_spectacle d WHERE idU = $id AND d.idDate = su.idDate AND d.valide=1) $ville";
		break;
		case "attente":
			//Dates en attente
			$SQL="SELECT COUNT(*) FROM `eduroam_date_spectacle` d,eduroam_spectacle s WHERE d.idSpectacle = s.idSpectacle AND valide = 0 AND d.idDate NOT IN 
			(SELECT su.idDate FROM eduroam_spectacle_user su,eduroam_date_spectacle d WHERE idU = $id AND d.idDate = su.idDate AND d.valide=0) $ville";
		break;
		case "mesValidees":
			//Dates validées user
			$SQL="SELECT COUNT(*) FROM eduroam_date_spectacle ds, eduroam_spectacle_user su,eduroam_spectacle s WHERE ds.idSpectacle = s.idSpectacle AND su.idU=$id AND su.idDate = ds.idDate AND valide=0 $ville";
			
		break;
		case "mesAttentes":
			//Dates en attente user
			$SQL="SELECT COUNT(*) FROM eduroam_date_spectacle ds, eduroam_spectacle_user su,eduroam_spectacle s WHERE ds.idSpectacle = s.idSpectacle AND su.idU=$id AND su.idDate = ds.idDate AND valide=1 $ville";
		break;
	}

	return SQLGetChamp($SQL);

}

/**
 * Déclarer un utilisateur comme interessé pour des dates
 *
 * @param boolean $choix 1 => L'utilisateur s'intéresse aux dates, 0 => il se désinteresse
 * @param int $idU
 * @param Array $dates Les dates choisies par l'utilisateur
 * @return int le nombre de modifications
 */
function userInteresseDates($choix,$idU,$dates){
	
	$dates = json_decode($dates,TRUE);
	$i=0;
	if($choix == 1){
		//Intéressé
		foreach ($dates as $value) {
			
			$idDate = $value["idDate"];
			$idSpectacle = $value["idSpectacle"];
			$notif = getNotifUser($idU);
			$SQL = "INSERT INTO eduroam_spectacle_user VALUES ($idDate,$idU,$idSpectacle,$notif)";
			if(SQLInsert($SQL)) 
				$i++;
		}
	}
	else if($choix == 2){
		//Plus intéressé
		foreach ($dates as $value) {
			$idDate = $value["idDate"];
			$SQL = "DELETE FROM eduroam_spectacle_user WHERE idDate=$idDate AND idU=$idU";
			if(SQLUpdate($SQL))
				$i++;
		}
	}
	return $i;
}

/**
 * Modifie le lien vers le site de billets pour une date
 *
 * @param int $idDate
 * @param string $lien
 * @return 1 si la modif a eu lieu, 0 sinon, false si pb
 */
function modifLien($idDate,$lien){
	$SQL = "UPDATE eduroam_date_spectacle SET lien = '$lien' WHERE idDate = $idDate";
	return SQLUpdate($SQL);
}

/**
 * Récupère toutes les dates existantes dans la BDD
 *
 * @return Array toutes les dates
 */
function recupToutesLesDates(){
	$SQL = "SELECT idDate,dateSpectacle FROM eduroam_date_spectacle";
	return parcoursRs(SQLSelect($SQL));
}

/**
 * Renvoie un tableau contenant les adresses mail de tous les utilisateurs
 * qui sont interessés à la date $date, et qui sont élligibles à recevoir des mails.
 *
 * @param date $date Date au format yyyy-mm-dd
 * @return Array les utilisateurs qui recevront un mail
 */
function trouverUsersDateValidee($date){

	$SQL = "SELECT u.idU AS idU,u.email AS email FROM eduroam_user u,eduroam_spectacle_user su WHERE su.idDate='$date' AND su.idU=u.idU";
	$rep = parcoursRs(SQLSelect($SQL));
	$rep_finale = array();
	foreach($rep as $user){
		$currId = $user["idU"];
		if(getNotifUser($currId) == 0)continue;
		$lastMail = getLastMail($currId);

		if(mailPossible($currId)) array_push($rep_finale,$user["email"]);
	}

	return $rep_finale;

}

/**
 * 
 * 			FIN FONCTIONS POUR LES SPECTACLES
 * 
 */


/**
 * Fonctions pour les vidéos
 */

function addVideo($id, $date, $title, $description, $thumbnails) {
	$title = str_replace("&#39","&#039",$title);
	$SQL = "INSERT INTO eduroam_video VALUES('0','$id','$date','$title','$description','$thumbnails','1')";
	SQLUpdate($SQL);
}

function verifExistVideo($id){
	$SQL = "SELECT COUNT(*) FROM eduroam_video WHERE videoId='$id'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

function setChecked($id) {
	$SQL = "UPDATE eduroam_video SET checked=1 WHERE videoId='$id'";
	SQLUpdate($SQL);
}

function setDesc($id, $description) {
	$SQL = "UPDATE eduroam_video SET description='$description' WHERE videoId='$id'";
	SQLUpdate($SQL);
}

function clearChecked() {
	$SQL = "UPDATE eduroam_video SET checked=0";
	SQLUpdate($SQL);
}

function deleteUnchecked() {
	$SQL = "DELETE FROM eduroam_video WHERE checked=0";
	SQLUpdate($SQL);
}

function getLastVideos() {
	$SQL = "SELECT videoId FROM eduroam_video ORDER BY publishedAt DESC";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function getRandomVideo(){
	$SQL = "SELECT videoId FROM eduroam_video ORDER BY RAND() LIMIT 1";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function getVideos($search='', $page='', $limite, $notID='', $apres, $avant, $serie="-1") {
	//setlocale(LC_TIME, "fr_FR"); //Inutile enfaite je pense
	$offset = ($page!= '') ? "OFFSET ".$page*$limite : "" ;
	$notID = ($notID!= '') ? "AND videoId NOT LIKE '".$notID."'" : "" ;
	$apres = ($apres!= '') ? "AND publishedAt >'".$apres."'" : "" ;
	$avant = ($avant!= '') ? "AND publishedAt <'".$avant."'" : "" ;
	//echo $serie;
	if($serie=="-1")
		$serieFilter = "";
	else {
		$regexs = getSerieRegex($serie);
		//print_r($regexs);
		$serieFilter ="AND (";
		foreach ($regexs as $regex) {
			$serieFilter.="REPLACE(title, ' ', '') LIKE REPLACE('%".$regex["regex"]."%', ' ', '') OR ";
		}
		$serieFilter = substr($serieFilter, 0, -3);
		$serieFilter .= ")";
		/* echo $serieFilter;
		echo htmlspecialchars("'", ENT_QUOTES); */
		
	}
	$SQL = "SELECT * FROM eduroam_video WHERE (title LIKE '%$search%' OR description LIKE '%$search%') $serieFilter $notID $apres $avant ORDER BY publishedAt DESC LIMIT $limite $offset";
	//echo $SQL;
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getVideosByDateSup($date, $notID='', $limite) {
	//echo $page;
	$SQL = "SELECT * FROM eduroam_video WHERE publishedAt>='$date' AND videoId NOT LIKE '$notID' ORDER BY publishedAt ASC LIMIT $limite";
	//echo $SQL;
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getVideosByDateInf($date, $notID='', $limite) {
	//echo $page;
	$SQL = "SELECT * FROM eduroam_video WHERE publishedAt<='$date' AND videoId NOT LIKE '$notID' ORDER BY publishedAt DESC LIMIT $limite";
	//echo $SQL;
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getDateById($id) {
	$SQL = "SELECT publishedAt FROM eduroam_video WHERE videoId='$id'";
	$rs = SQLGetChamp($SQL);
	return $rs; 
}

function getVideosCount($search, $avant, $apres, $serie="-1") {
	$apres = ($apres!= '') ? "AND publishedAt >'".$apres."'" : "" ;
	$avant = ($avant!= '') ? "AND publishedAt <'".$avant."'" : "" ;
	if($serie=="-1")
		$serieFilter = "";
	else {
		$regexs = getSerieRegex($serie);
		//print_r($regexs);
		$serieFilter ="AND (";
		foreach ($regexs as $regex) {
			$serieFilter.="REPLACE(title, ' ', '') LIKE REPLACE('%".$regex["regex"]."%', ' ', '') OR ";
		}
		$serieFilter = substr($serieFilter, 0, -3);
		$serieFilter .= ")";
	}
	//$SQL = "SELECT COUNT(*) FROM video WHERE title LIKE '%$search%' OR description LIKE '%$search%'"; 
	$SQL = "SELECT COUNT(*) FROM eduroam_video WHERE (title LIKE '%$search%' OR description LIKE '%$search%') $serieFilter $apres $avant";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

/**
 * Fonctions pour les rôles
 */

function addRole($nom, $droits) {
	$SQL = "INSERT INTO eduroam_role VALUES('0','$nom', '".json_encode($droits)."')";
	SQLUpdate($SQL);
	$SQL2 = "SELECT idRole FROM eduroam_role ORDER BY idRole DESC";
	$rs = SQLGetChamp($SQL2);
	return $rs;
}

function deleteRole($idRole){
	$SQL = "DELETE FROM eduroam_role WHERE idRole = $idRole";
	return SQLDelete($SQL);
	$SQL = "DELETE FROM eduroam_user_role WHERE idRole = $idRole";
	return SQLDelete($SQL);
}

function editRole($idRole, $nom, $droits){
	$SQL = "UPDATE eduroam_role SET nom='$nom', droits='".json_encode($droits)."' WHERE idRole='$idRole'";
	SQLUpdate($SQL);
}

function getDroitByRole($idRole, $droit) {
	$SQL = "SELECT droits FROM eduroam_role WHERE idRole=$idRole;"; 
	$rs = SQLGetChamp($SQL);
	$rs = json_decode($rs, true);
	//print_r($rs);
	return $rs["$droit"];
}

function getDroitByUser($idUser, $droit) {
	$SQL = "SELECT eduroam_role.droits FROM eduroam_role, eduroam_user_role WHERE eduroam_role.idRole=eduroam_user_role.idRole AND eduroam_user_role.idU=$idUser;"; 
	$rs = SQLGetChamp($SQL);
	$rs = json_decode($rs, true);
	//print_r($rs);
	return $rs[$droit];
}

function getDroit($droit) {
	$SQL = "SELECT eduroam_role.droits FROM eduroam_role, eduroam_user_role WHERE eduroam_role.idRole=eduroam_user_role.idRole AND eduroam_user_role.idU=".valider("idUser","SESSION").";"; 
	$rs = SQLGetChamp($SQL);
	$rs = json_decode($rs, true);
	//print_r($rs);
	return $rs[$droit];
}

function getRoles() {
	$SQL = "SELECT idRole, nom FROM eduroam_role";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getRolesIdByUser($idUser) {
	$SQL = "SELECT idRole FROM eduroam_user_role WHERE idU='$idUser'";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function checkIfUserHasRole($idUser, $idRole) {
	$SQL = "SELECT COUNT(idRole) FROM eduroam_user_role WHERE idU='$idUser' AND idRole='$idRole';";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function countUsers() {
	$SQL = "SELECT COUNT(*) FROM `eduroam_user`";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function searchUsersByTag($tag) {
	$SQL = "SELECT * FROM eduroam_user WHERE CONCAT(prenom, ' ', nom, ' (', email, ')') LIKE '$tag%' OR CONCAT(nom, ' ', prenom, ' (', email, ')') LIKE '$tag%' OR CONCAT(email, ' (', prenom, ' ', nom, ')') LIKE '$tag%' LIMIT 5";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function editUser ($idU, $email, $prenom, $nom) {
	$SQL = "UPDATE eduroam_user SET prenom='$prenom', nom='$nom', email='$email' WHERE idU='$idU'";
	SQLUpdate($SQL);
}

function setAdmin($idU) {
	$SQL = "UPDATE eduroam_user SET superadmin=1 WHERE idU='$idU'";
	SQLUpdate($SQL);
}

function removeAdmin($idU) {
	$SQL = "UPDATE eduroam_user SET superadmin=0 WHERE idU='$idU'";
	SQLUpdate($SQL);
}

function giveRole($idU, $idRole) {
	if(!checkIfUserHasRole($idU, $idRole)) {
		$SQL = "INSERT INTO eduroam_user_role VALUES('$idU','$idRole')";
		SQLUpdate($SQL);
	}
}

function removeRole($idU, $idRole) {
	if(checkIfUserHasRole($idU, $idRole)) {
		$SQL = "DELETE FROM eduroam_user_role WHERE idU='$idU' AND idRole='$idRole'";
		SQLDelete($SQL);
	}
}

function banUser($idU) {
	$SQL = "UPDATE eduroam_user SET banni=1 WHERE idU='$idU'";
	SQLUpdate($SQL);
}

function unbanUser($idU) {
	$SQL = "UPDATE eduroam_user SET banni=0 WHERE idU='$idU'";
	SQLUpdate($SQL);
}

/**
 * Fonctions qui gèrent les séries
 */

function getSeries() {
	$SQL = "SELECT * FROM eduroam_serie";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function addSeries($nom) {
	$SQL = "INSERT INTO eduroam_serie VALUES('0','$nom')";
	SQLUpdate($SQL);
	$SQL2 = "SELECT id_serie FROM eduroam_serie ORDER BY id_serie DESC";
	$rs = SQLGetChamp($SQL2);
	return $rs;
}

function deleteSerie($id) {
	deleteRegexViaSerie($id);
	$SQL = "DELETE FROM eduroam_serie WHERE id_serie = $id";
	return SQLDelete($SQL);
}

function getFirstSerie() {
	$SQL = "SELECT id_serie FROM eduroam_serie ORDER BY id_serie";
	return SQLGetChamp($SQL);
}

function getFirstSerieRegex() {
	$first=getFirstSerie();
	$SQL = "SELECT * FROM eduroam_serie_regex WHERE id_serie='$first'";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getSerieRegex($id) {
	$SQL = "SELECT * FROM eduroam_serie_regex WHERE id_serie='$id'";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function addRegex($id, $regex) {
	$regex = htmlspecialchars($regex, ENT_QUOTES | ENT_HTML401);
	$SQL = "INSERT INTO eduroam_serie_regex VALUES('0','$id','$regex')";
	SQLUpdate($SQL);
	$SQL2 = "SELECT id_regex FROM eduroam_serie_regex ORDER BY id_regex DESC";
	$rs = SQLGetChamp($SQL2);
	return $rs;
}

function editRegex($id, $regex){
	$regex = htmlspecialchars($regex, ENT_QUOTES | ENT_HTML401);
	$SQL = "UPDATE eduroam_serie_regex SET regex='$regex' WHERE id_regex=$id";
	SQLUpdate($SQL);
}

function deleteRegex($id) {
	$SQL = "DELETE FROM eduroam_serie_regex WHERE id_regex = $id;";
	return SQLDelete($SQL);
}

function deleteRegexViaSerie($id) {
	$SQL = "DELETE FROM eduroam_serie_regex WHERE id_serie = $id;";
	return SQLDelete($SQL);
}

/* Annonces */

function addAccueil($type, $id) {
	$SQL = "INSERT INTO eduroam_accueil VALUES('0', '$type', '$id')";
	SQLUpdate($SQL);
}

function addAnnonce($contenu, $user) {
	$SQL = "INSERT INTO eduroam_article VALUES('0','$user', CURRENT_DATE,'$contenu')";
	SQLUpdate($SQL);
	$SQL2 = "SELECT idArticle FROM eduroam_article ORDER BY idArticle DESC";
	$rs = SQLGetChamp($SQL2);
	addAccueil("annonce", $rs);
}

function editAnnonce($id, $contenu){
	$SQL = "UPDATE eduroam_article SET contenu='$contenu' WHERE idArticle='$id'";
	echo $SQL;
	SQLUpdate($SQL);
}

function addSondage($intitule, $user, $hideResult, $endDate) {
	$SQL = "INSERT INTO eduroam_sondage VALUES('0', '$user', '$intitule', '$hideResult', '$endDate', CURRENT_DATE)";
	SQLUpdate($SQL);
	$SQL2 = "SELECT idSondage FROM eduroam_sondage ORDER BY idSondage DESC";
	$rs = SQLGetChamp($SQL2);
	addAccueil("sondage", $rs);
	return $rs;
}

function addChoix($idSondage, $question) {
	$SQL = "INSERT INTO eduroam_choix_sondage VALUES('0', '$idSondage', '$question')";
	SQLUpdate($SQL);
}

function getAccueils($offset) {
	$SQL = "SELECT * FROM eduroam_accueil ORDER BY id DESC LIMIT 5 OFFSET $offset";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function countAccueils() {
	$SQL = "SELECT COUNT(*) FROM eduroam_accueil";
	$rs = SQLGetChamp($SQL);
	return $rs; 
}

function getAccueilById($id) {
	$SQL = "SELECT * FROM eduroam_accueil WHERE id=$id";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getAnnonceById($id) {
	$SQL = "SELECT * FROM eduroam_article WHERE idArticle=$id";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getSondageById($id) {
	$SQL = "SELECT * FROM eduroam_sondage WHERE idSondage=$id";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getChoix($id) {
	$SQL = "SELECT * FROM eduroam_choix_sondage WHERE idSondage=$id";
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getReponseCountBySondage($id) {
	$SQL = "SELECT COUNT(eduroam_choix_user.idU) FROM eduroam_choix_user, eduroam_choix_sondage WHERE eduroam_choix_user.idChoix = eduroam_choix_sondage.idChoix AND eduroam_choix_sondage.idSondage = $id";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function getReponseCountByChoix($id) {
	$SQL = "SELECT COUNT(*) FROM eduroam_choix_user WHERE idChoix = $id";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function hasVoted($idU, $idSondage) {
	$SQL = "SELECT COUNT(eduroam_choix_user.idU) FROM eduroam_choix_user, eduroam_choix_sondage WHERE eduroam_choix_user.idChoix = eduroam_choix_sondage.idChoix AND eduroam_choix_sondage.idSondage = $idSondage AND eduroam_choix_user.idU = $idU";
	$rs = SQLGetChamp($SQL);
	return $rs;
}

function addVote($idU, $idChoix) {
	$SQL = "INSERT INTO eduroam_choix_user VALUES('$idU', '$idChoix')";
	SQLUpdate($SQL);
}

function removeAnnonce($id) {
	$SQL = "DELETE FROM eduroam_article WHERE idArticle='$id'";
	SQLDelete($SQL);
}

function removeSondage($id) {
	$SQL = "DELETE FROM eduroam_sondage WHERE idSondage='$id'";
	SQLDelete($SQL);
}


function removeAccueil($id) {
	$accueil = getAccueilById($id);
	if($accueil[0]["type"]=="sondage") {
		removeSondage($accueil[0]["id_annonce"]);
	} else {
		removeAnnonce($accueil[0]["id_annonce"]);
	}
	$SQL = "DELETE FROM eduroam_accueil WHERE id=$id";
	SQLDelete($SQL);
}

?>
