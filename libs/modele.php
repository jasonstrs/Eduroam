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
 * Retourne le id
 */
function getIdViaHash($hash)
{
	
	$SQL="SELECT idU FROM eduroam_user WHERE hashCode='$hash'";
	return SQLGetChamp($SQL);
}

function getIdViaMail($email)
{
	
	$SQL="SELECT idU FROM eduroam_user WHERE email='$email'";
	return SQLGetChamp($SQL);
}

/**
 * Verif si l'utilisateur a confirmé son mail
 * Return 1 si c'est validé
 */
function isConfirm($idUser)
{
	// vérifie si l'utilisateur a validé son mail
	$SQL ="SELECT code FROM eduroam_user WHERE idU='$idUser'";
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
	$SQL ="SELECT code FROM eduroam_user WHERE email='$email'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

/**
 * L'utilisateur vient de changer son mdp
 */
function changePass ($id,$newPasse) {
	$SQL = "UPDATE eduroam_user SET passe='$newPasse' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * L'utilisateur vient de changer son choix de recevoir des mails
 */
function changeValue ($id,$choice) {
	$SQL = "UPDATE eduroam_user SET choice='$choice' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * L'utilisateur vient de changer son prenom
 */
function changeFirstName ($id,$new) {
	$SQL = "UPDATE eduroam_user SET prenom='$new' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * L'utilisateur vient de changer son nom
 */
function changeName ($id,$new) {
	$SQL = "UPDATE eduroam_user SET nom='$new' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * On change le hashCode d'un user
 */
function changeHash($oldHash,$id,$newHash){
	$SQL="UPDATE eduroam_user SET hashCode='$newHash' WHERE hashCode='$oldHash' AND idU='$id'";
	SQLUpdate($SQL);
}
	
/**
 * L'utilisateur vient de confirmer son adresse
 */
function confirmAdress ($id) {
	$SQL = "UPDATE eduroam_user SET code=1 WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * Créer un utilisateur
 */
function createUser($email,$nom,$prenom,$passe,$hashCode){
	$SQL = "INSERT INTO eduroam_user(email,nom,prenom,passe,superadmin,code,hashCode) VALUES('$email','$nom','$prenom','$passe','0','0','$hashCode') ";
	SQLUpdate($SQL);
}

/**
 * Renvoie true si l'adresse mail est deja dans la BDD
 */
function verifExistMail($email){
	$SQL = "SELECT COUNT(*) FROM eduroam_user WHERE email='$email'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

/**
 * Renvoie 0 si l'utilisateur ne veut pas de notif, 1 sinon
 */
function getNotifUser($idU){
	$SQL = "SELECT choice FROM eduroam_user WHERE idU=$idU";
	return(SQLGetChamp($SQL));
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

		$SQLGetDates = "SELECT * FROM eduroam_date_spectacle WHERE idSpectacle=".$ligne['idSpectacle']." AND valide='0'";
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
 * Renvoie true si la ville N'EST PAS dans la base de données
 */
function verifVilleNom($nom){
	$SQL = "SELECT COUNT(*) FROM eduroam_spectacle WHERE ville='$nom'";
	if(SQLGetChamp($SQL) == 0)return true;
	return false;
}



function creerSpectacle($ville,$description){
	$SQL = "INSERT INTO eduroam_spectacle (ville,description) VALUES ('$ville','$description')";
	return SQLInsert($SQL);
}

function ajouterDateSpectacle($id,$date){
	$SQL = "INSERT INTO eduroam_date_spectacle (idSpectacle,dateSpectacle) VALUES ($id,'$date')";
	return SQLInsert($SQL);
}

function supprimerDate($idDate){
	$SQL = "DELETE FROM eduroam_date_spectacle WHERE idDate = $idDate";
	return SQLDelete($SQL);
}

function supprimerSpectacle($id){
	$SQL = "DELETE FROM eduroam_spectacle WHERE idSpectacle = $id";
	return SQLDelete($SQL);
}

function validerDate($id,$lien){
	$SQL = "UPDATE eduroam_date_spectacle SET valide='1',lien='$lien' WHERE idDate='$id'";
	return SQLUpdate($SQL);
}


function nbDates($valid){
	
	switch($valid){
		case "attente":
			$valid=0;
		break;
		case "validees":
			$valid=1;
		break;
		default:
			return json_encode(array("success" => 0));
		break;
	}
	$SQL="SELECT COUNT(*) FROM eduroam_date_spectacle WHERE valide=$valid";
	return SQLGetChamp($SQL);
}

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

function nbInscritsDate($idDate){
	$SQL="SELECT COUNT(*) FROM eduroam_spectacle_user WHERE idDate='$idDate'";
	return SQLGetChamp($SQL);
}

function nbDatesUser($choix,$id,$ville){
	if($ville != "")$ville = "AND s.ville = '$ville'";
	switch($choix){
		case "validees":
			//Dates validées
			$SQL="SELECT COUNT(*) FROM `eduroam_date_spectacle` d,eduroam_spectacle s WHERE d.idSpectacle = s.idSpectacle AND valide = 1 AND d.idDate NOT IN 
			(SELECT su.idDate FROM eduroam_spectacle_user su,eduroam_date_spectacle d WHERE idU = $id AND d.idDate = su.idDate AND d.valide=1) $ville";
			/* SELECT idDate FROM spectacle_user WHERE idU = 2 */
/* SELECT d.idDate FROM `date_spectacle` d,spectacle_user su WHERE valide = 1 AND d.idDate NOT IN (SELECT idDate FROM spectacle_user WHERE idU = 2) */		
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
			SQLInsert($SQL);
			$i++;
		}
	}
	else if($choix == 2){
		//Plus intéressé
		foreach ($dates as $value) {
			$idDate = $value["idDate"];
			$SQL = "DELETE FROM eduroam_spectacle_user WHERE idDate=$idDate AND idU=$idU";
			SQLUpdate($SQL);
			$i++;
		}
	}
	return $i;
}

function modifLien($idDate,$lien){
	$SQL = "UPDATE eduroam_date_spectacle SET lien = '$lien' WHERE idDate = $idDate";
	return SQLUpdate($SQL);
}

function recupToutesLesDates(){
	$SQL = "SELECT idDate,dateSpectacle FROM eduroam_date_spectacle";
	return parcoursRs(SQLSelect($SQL));
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
	$SQL = "INSERT INTO eduroam_sondage VALUES('0', '$user', '$intitule', '$hideResult', $endDate, CURRENT_DATE)";
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
