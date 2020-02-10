<?php
    include_once "../libs/maLibUtils.php";
    include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
   include_once "../libs/modele.php";
   include_once "../libs/maLibPHPMailer.php";
   
    /*if (valider("email","POST") && valider("passe","POST") && valider("checked","POST")){ // on vérifie que toutes les valeurs sont définies
        $email = valider('email',"POST");
        $passe = sha1(md5(valider('passe',"POST")));
        $check = valider("checked","POST");

        $aux = verifUser($email,$passe,$check); // verifie si l'utilisateur est dans la bdd et si il a confirmé son mail
                                                // on peut aussi savoir si on garde l'utilisateur en cookie
        echo $aux;
    }*/

    if(!($action = valider("action","POST"))){
        header("Location:../index.php?view=accueil");
    }

    switch($action){
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
                
                if (verifExistMail($email)){
                    echo "Exist";
                } else {
                    $hashCode = md5(uniqid(rand(), true));
                    $id =createUser($email,$nom,$prenom,$passe,$hashCode);
                    
                    // on envoie un mail : A AJOUTER
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
                   
                        // ici on envoie un mail pour récup le mdp /////////////////////////////////////////////
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
                        // ici on envoie un mail /////////////////////////////////////////////
                        echo "success";
                    }
                } else {
                    echo "incorrect";
                }
            } else { // sécurité
                header("Location:../index.php?view=accueil");
            }
        break;

    }
    
?>