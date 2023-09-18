<?php

/**
 * Le contrÃ´leur :
 * - dÃ©finit le contenu des variables Ã  afficher
 * - identifie et appelle la vue
 */ 

/**
 * ContrÃ´leur de l'utilisateur
 */

// on inclut le fichier modÃ¨le contenant les appels Ã  la BDD
include('requetes.utilisateurs.php');

// si la fonction n'est pas dÃ©finie, on choisit d'afficher l'accueil
if (!isset($_GET['fonction']) || empty($_GET['fonction'])) {
    $function = "accueil";
} else {
    $function = $_GET['fonction'];
}

switch ($function) {
    
    case 'accueil':
        //affichage de l'accueil
        $vue = "accueil";
        $title = "Accueil";
        break;
        
        
    case 'inscription':
    // inscription d'un nouvel utilisateur
        $vue = "inscription";
        $alerte = false;
        
        // Cette partie du code est appelÃ©e si le formulaire a Ã©tÃ© postÃ©
        if (isset($_POST['username']) and isset($_POST['password'])) {
            
            if( !estUneChaine($_POST['username'])) {
                $alerte = "Le nom d'utilisateur doit Ãªtre une chaÃ®ne de caractÃ¨re.";
                
            } else if( !estUnMotDePasse($_POST['password'])) {
                $alerte = "Le mot de passe n'est pas correct.";
                
            } else {
                // Tout est ok, on peut inscrire le nouvel utilisateur
                
                // 
                $values = [
                    'username' => $_POST['username'],
                    'password' => crypterMdp($_POST['password']) // on crypte le mot de passe
                ];

                // Appel Ã  la BDD Ã  travers une fonction du modÃ¨le.
                $retour = ajouteUtilisateur($bdd, $values);
                
                if ($retour) {
                    $alerte = "Inscription réussie";
                } else {
                    $alerte = "L'inscription dans la BDD n'a pas fonctionnée";
                }
            }
        }
        $title = "Inscription";
        break;
        
    case 'liste':
    // Liste des utilisateurs dÃ©jÃ  enregistrÃ©s
        $vue = "liste";
        $title = "Liste des utilisateurs inscrits";
        $entete = "Voici la liste :";
        
        $liste = recupereTousUtilisateurs($bdd);
        
        if(empty($liste)) {
            $alerte = "Aucun utilisateur inscrit pour le moment";
        }
        
        break;
        
    default:
        // si aucune fonction ne correspond au paramÃ¨tre function passÃ© en GET
        $vue = "erreur404";
        $title = "error404";
        $message = "Erreur 404 : la page recherchée n'existe pas.";
}

include ('header.php');
//include ('vues/' . $vue . '.php');
include ('footer.php');

