<?php
session_start();
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";
   include_once "../libs/maLibPHPMailer.php";
  

    if(!($action = valider("action","POST"))){ // si une requête n'est pas POST
        if (valider("action","GET") && valider("action","GET") == "logout") // si elle est GET et c'est deconnexion
            $action = valider("action","GET"); // c'est good
        else
            header("Location:../index.php?view=accueil"); // sinon on renvoie
    }

    // Variable qui va permettre d'envoyer les mails
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    switch($action){

        case 'logout' : 
            session_destroy();
            header("Location:../index.php?view=accueil");
        break;

        case 'Connexion' :
            if (valider("email","POST") && valider("passe","POST") && valider("checked","POST")){ // on vérifie que toutes les valeurs sont définies
                $email = valider('email',"POST");
                $passe = sha1(md5(valider('passe',"POST")));
                $check = valider("checked","POST");
        
                $aux = verifUser($email,$passe,$check); // verifie si l'utilisateur est dans la bdd et si il a confirmé son mail
                                                        // on peut aussi savoir si on garde l'utilisateur en cookie

                echo $aux;
            } else { // sécurité
                header("Location:../index.php?view=accueil");
            }
        break;

        case 'Inscription' :
            if (valider("email","POST") && valider("passe","POST") && valider("nom","POST") && valider("prenom","POST")){
                $email = valider("email","POST");
                $passe = sha1(md5(valider("passe","POST")));
                $nom = valider("nom","POST");
                $prenom=valider("prenom","POST");

                /**
                 * On cherche à vérifier si les données saisies sont bien correctes !
                 */
                if (!preg_match("#^[a-zâäàéèùêëîïôöçñ \-]+$#i",$nom) || !preg_match("#^[a-zâäàéèùêëîïôöçñ \-]+$#i",$prenom)
                || !preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$#i",valider("passe","POST")) ||
                !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$#i",$email))
                    echo "Error";
                
                else if (verifExistMail($email)){
                    echo "Exist";
                } else {
                    $hashCode = md5(uniqid(rand(), true));
                    $id =createUser($email,$nom,$prenom,$passe,$hashCode);
                    $lien = $url . '/Eduroam/controleur.php?action=verificationMail&hash='.$hashCode;
                    envoiMail($email,"Finaliser votre inscription",$nom,$prenom,$lien);
                    echo "Success";
                }   
            } else { // sécurité
                header("Location:../index.php?view=accueil");
            }
        break;

        case 'PassWord' :
            if (valider("email","POST")){ // on vérifie que toutes les valeurs sont définies
                $email = valider('email',"POST");
                if (verifExistMail($email)){ // l'adresse est existante
                    $id = getIdViaMail($email);
                    $hashCode = hashCode($id);
                    $prenom = getPrenom($id);
                    $nom = getNom($id);
                    $lien = $url . '/Eduroam/controleur.php?action=verificationPassword&hash='.$hashCode;
                    envoiMailPass($email,"Mot de passe",$nom,$prenom,$lien);
                    echo "success";
                    
                } else {
                    echo "incorrect";
                }
            } else { // sécurité
                header("Location:../index.php?view=accueil");
            }
        break;

        case 'NewMail' :
            if (valider("email","POST")){ // on vérifie que toutes les valeurs sont définies
                $email = valider('email',"POST");
                if (verifExistMail($email)){ // l'adresse est existante
                    if(isConfirmViaMail($email)){ // on regarde si le mail est déjà confirmé
                        echo "confirm";
                    } else {
                        $id = getIdViaMail($email);
                        $hashCode = hashCode($id);
                        $prenom = getPrenom($id);
                        $nom = getNom($id);
                        $lien = $url . '/Eduroam/controleur.php?action=verificationMail&hash='.$hashCode;
                        envoiMail($email,"Finaliser votre inscription",$nom,$prenom,$lien);
                        echo "success";
                        
                    }
                } else {
                    echo "incorrect";
                }
            } else { // sécurité
                header("Location:../index.php?view=accueil");
            }
        break;

        case 'modificationPasse' :
            $hash = valider("hash","POST");
            if(!preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$#i",valider("passe","POST")))
                echo 'ERROR';
            else {
                $passe = sha1(md5(valider("passe","POST")));
                $id = getIdViaHash($hash);
                
                if ($id) {
                    changePass($id,$passe);
                    changeHash($hash,$id,md5(uniqid(rand(), true)));
                    echo 'SUCCESS';
                } else {
                    echo 'ERROR';
                }
            }
        break;

    }
    
?>