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

	$SQL="SELECT idU FROM user WHERE email='$email' AND passe='$passe'";

	return SQLGetChamp($SQL);
}

/**
 * Retourne le hash
 */
function hashCode($id)
{
	
	$SQL="SELECT hashCode FROM user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

function isSuperAdmin($id,$hash){
	return SQLGetChamp("SELECT superadmin FROM user WHERE idU='$id' AND hashCode='$hash'");
}



function getPrenom($id)
{
	
	$SQL="SELECT prenom FROM user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

function getNom($id)
{
	
	$SQL="SELECT nom FROM user WHERE idU='$id'";
	return SQLGetChamp($SQL);
}

/**
 * Retourne le id
 */
function getIdViaHash($hash)
{
	
	$SQL="SELECT idU FROM user WHERE hashCode='$hash'";
	return SQLGetChamp($SQL);
}

function getIdViaMail($email)
{
	
	$SQL="SELECT idU FROM user WHERE email='$email'";
	return SQLGetChamp($SQL);
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
 * L'utilisateur vient de changer son mdp
 */
function changePass ($id,$newPasse) {
	$SQL = "UPDATE user SET passe='$newPasse' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * L'utilisateur vient de changer son prenom
 */
function changeFirstName ($id,$new) {
	$SQL = "UPDATE user SET prenom='$new' WHERE idU='$id'";
	SQLUpdate($SQL);
}

/**
 * L'utilisateur vient de changer son nom
 */
function changeName ($id,$new) {
	$SQL = "UPDATE user SET nom='$new' WHERE idU='$id'";
	SQLUpdate($SQL);
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
	$SQL = "SELECT idSpectacle,ville,description FROM spectacle";
	$SQL = SQLSelect($SQL);
	$SQL = parcoursRs($SQL);
	foreach($SQL as $ligne){
		$SQLNbInteresses = "SELECT COUNT(*) FROM spectacle_user WHERE idSpectacle=".$ligne['idSpectacle'];
		$SQLNbInteresses = SQLGetChamp($SQLNbInteresses);

		$SQLNbSpecVille = "SELECT COUNT(*) FROM spectacle WHERE ville=\"".$ligne['ville']."\"";
		$SQLNbSpecVille = SQLGetChamp($SQLNbSpecVille);

		$SQLGetDates = "SELECT * FROM date_spectacle WHERE idSpectacle=".$ligne['idSpectacle']." AND valide='0'";
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
	/* $SQL = "SELECT s.idSpectacle AS id,s.ville AS nom,s.description AS _description
	, COUNT(ds.idDate),COUNT(su)"; */
	
}


/**
 * Renvoie true si la ville N'EST PAS dans la base de données
 */
function verifVilleNom($nom){
	$SQL = "SELECT COUNT(*) FROM spectacle WHERE ville='$nom'";
	if(SQLGetChamp($SQL) == 0)return true;
	return false;
}



function creerSpectacle($ville,$description){
	$SQL = "INSERT INTO spectacle (ville,description) VALUES ('$ville','$description')";
	return SQLInsert($SQL);
}

function ajouterDateSpectacle($id,$date){
	$SQL = "INSERT INTO date_spectacle (idSpectacle,dateSpectacle) VALUES ($id,'$date')";
	return SQLInsert($SQL);
}

function supprimerDate($idDate){
	$SQL = "DELETE FROM date_spectacle WHERE idDate = $idDate";
	return SQLDelete($SQL);
}

function supprimerSpectacle($id){
	$SQL = "DELETE FROM spectacle WHERE idSpectacle = $id";
	return SQLDelete($SQL);
}

function validerDate($id){
	$SQL = "UPDATE date_spectacle SET valide='1' WHERE idDate='$id'";
	return SQLUpdate($SQL);
}



/**
 * Fonctions pour les vidéos
 */

function addVideo($id, $date, $title, $description, $thumbnails) {
	$SQL = "INSERT INTO video VALUES('0','$id','$date','$title','$description','$thumbnails','1')";
	SQLUpdate($SQL);
}

function verifExistVideo($id){
	$SQL = "SELECT COUNT(*) FROM video WHERE videoId='$id'";
	if(SQLGetChamp($SQL))return 1;
	return 0; 
}

function setChecked($id) {
	$SQL = "UPDATE video SET checked=1 WHERE videoId='$id'";
	SQLUpdate($SQL);
}

function setDesc($id, $description) {
	$SQL = "UPDATE video SET description='$description' WHERE videoId='$id'";
	SQLUpdate($SQL);
}

function clearChecked() {
	$SQL = "UPDATE video SET checked=0";
	SQLUpdate($SQL);
}

function deleteUnchecked() {
	$SQL = "DELETE FROM video WHERE checked=0";
	SQLUpdate($SQL);
}

function getVideos($search='', $page='', $limite, $notID='', $apres, $avant) {
	setlocale(LC_TIME, "fr_FR");
	$offset = ($page!= '') ? "OFFSET ".$page*$limite : "" ;
	$notID = ($notID!= '') ? "AND videoId NOT LIKE '".$notID."'" : "" ;
	$apres = ($apres!= '') ? "AND publishedAt >'".$apres."'" : "" ;
	$avant = ($avant!= '') ? "AND publishedAt <'".$avant."'" : "" ;
	//echo $page;
	$SQL = "SELECT * FROM video WHERE (title LIKE '%$search%' OR description LIKE '%$search%') $notID $apres $avant ORDER BY publishedAt DESC LIMIT $limite $offset";
	//echo $SQL;
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getVideosByDateSup($date, $notID='', $limite) {
	//echo $page;
	$SQL = "SELECT * FROM video WHERE publishedAt>='$date' AND videoId NOT LIKE '$notID' ORDER BY publishedAt ASC LIMIT $limite";
	//echo $SQL;
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getVideosByDateInf($date, $notID='', $limite) {
	//echo $page;
	$SQL = "SELECT * FROM video WHERE publishedAt<='$date' AND videoId NOT LIKE '$notID' ORDER BY publishedAt DESC LIMIT $limite";
	//echo $SQL;
	$rs = SQLSelect($SQL);
	$tab = parcoursRs($rs);
	return $tab; 
}

function getDateById($id) {
	$SQL = "SELECT publishedAt FROM video WHERE videoId='$id'";
	$rs = SQLGetChamp($SQL);
	return $rs; 
}

function getVideosCount($search) {
	$SQL = "SELECT COUNT(*) FROM video WHERE title LIKE '%$search%' OR description LIKE '%$search%'"; 
	$rs = SQLGetChamp($SQL);
	return $rs;
}

?>
