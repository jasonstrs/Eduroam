<?php
    /* session_start(); */
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    include_once "../libs/modele.php";
    
if(!($action = valider("action","POST"))){
    header("Location:../index.php?view=accueil");
}

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
        echo valider("changePass","POST");
        if(valider("changePass","POST")) {
            $password = sha1(md5(valider("password","POST")));
            echo "On change le password";
            echo $password;
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