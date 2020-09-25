<?php
    /* session_start(); */
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    session_start();

    
if(!($action = valider("action","POST"))){
    header("Location:../index.php?view=accueil");
}

if( !($idU = valider("idUser","SESSION")))die("Non connecte");
$hash = valider("hash","SESSION");
if(!isSuperAdmin($idU,$hash) && !getDroitByUser($idU,"utilisateurs"))die("Pas les droits");

$action = valider("action","POST");
switch($action){

    case 'search' : 
        $tag = valider("tag","POST");
        echo json_encode(searchUsersByTag($tag));
    break;
    case 'getRoles' : 
        echo json_encode(getRoles());
    break;
    case 'getRolesByUser' : 
        $idU = valider("idU","POST");
        echo json_encode(getRolesIdByUser($idU));
    break;
    case 'save' : 
        $idU = valider("idU","POST");
        $email = valider("email","POST");
        $prenom = valider("prenom","POST");
        $nom = valider("nom","POST");        

        /**
         * On cherche à vérifier si les données saisies sont bien correctes !
         */
        if (!preg_match("#^[a-zâäàéèùêëîïôöçñ\\\' \-]+$#i",$nom) || !preg_match("#^[a-zâäàéèùêëîïôöçñ \-]+$#i",$prenom) ||
        !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$#i",$email))
            die(json_encode(array("success"=>false,"msg"=>"Nom, Prénom ou Email incorrect")));

        if(valider("changePass","POST")) {
            $pass = valider("password","POST");
            $password = sha1(md5($pass));
            
            //!preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$&+,:;=?@#\|'<>.\-\^\*()%!])[A-Za-z\d$&+,\-:;=?@#\|'<>.\^\*()%!]{8,}$#i",$password)
            // @#\-_$%^&+=§!\?

            

            if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$&+,:;=?@\#|\'<>.\-\^\*()%!])[A-Za-z\d$&+,\-:;=?@\#|\'<>.\^\*()%!]{8,}$#i',$pass))
                die(json_encode(array("success"=>false,"msg"=>"Veuillez saisir un mot de passe valide (8 caractères minimum dont 1 majuscule, 1 minuscule, 1 chiffre et un caractère spécial)")));
            
            changePass($idU,$password);
        }
        if(valider("admin","POST")=="true") {
            setAdmin($idU);
        }
        else if(isSuperAdmin($idU, hashCode($idU))) {
            removeAdmin($idU);
        }
        if($role = valider("role","POST")) {
            foreach ($role as $idRole => $change){
                if($change==-1) {
                    removeRole($idU, $idRole);
                }
                else {
                    giveRole($idU, $idRole);
                }
            }
        }
        editUser($idU, $email, $prenom, $nom);
        echo json_encode(array("success"=>true,"msg"=>"Succès"));

    break;
    case 'ban' : 
        $idU = valider("idU","POST");
        banUser($idU);
    break;
    case 'unban' : 
        $idU = valider("idU","POST");
        unbanUser($idU);
    break;
}


?>