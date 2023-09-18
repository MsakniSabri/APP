<?php

/**
 * ContrÃ´leur des capteurs
 */

// on inclut le fichier modÃ¨le contenant les appels Ã  la BDD
include('requetes.capteurs.php');

// si la fonction n'est pas dÃ©finie, on choisit d'afficher l'accueil
if (!isset($_GET['fonction']) || empty($_GET['fonction'])) {
    $function = "capteurs";
} else {
    $function = $_GET['fonction'];
}

switch ($function) {
    
    case 'capteurs':
        //liste des capteurs enregistrÃ©s
        
        $vue = "capteurs";
        $title = "Les capteurs";
        
        $entete = "Voici la liste des capteurs déjà  enregistrÃ©s :";
        
        $liste = recupereTous($bdd, $table);
        
        if(empty($liste)) {
            $alerte = "Aucun capteur enregistré pour le moment";
        }
        
        break;
        
    case 'ajout':
        //Ajouter un nouveau capteur
        
        $title = "Ajouter un capteur";
        $vue = "ajout";
        $alerte = false;
        
        // Cette partie du code est appelÃ©e si le formulaire a Ã©tÃ© postÃ©
        if (isset($_POST['name']) and isset($_POST['type'])) {
            
            if( !estUneChaine($_POST['name'])) {
                $alerte = "Le nom du capteur doit Ãªtre une chaine de caractère.";
                
            } else if( !estUneChaine($_POST['type'])) {
                $alerte = "Le type du capteur doit Ãªtre une chaÃ®ne de caractère.";
                
            } else {
                
                $values =  [
                    'name' => $_POST['name'],
                    'type' => $_POST['type']
                ];
                
                // Appel Ã  la BDD Ã  travers une fonction du modÃ¨le.
                $retour = insertion($bdd, $values, $table);
                
                if ($retour) {
                    $alerte = "Ajout réussie";
                } else {
                    $alerte = "L'ajout dans la BDD n'a pas fonctionnÃ©";
                }
            }
        }
        
        break;
        
    case 'recherche':
        // chercher des capteurs par type
        
        $title = "Rechercher des capteurs";
        $alerte = false;
        $vue = "recherche";
        
        // Cette partie du code est appelÃ©e si le formulaire a Ã©tÃ© postÃ©
        if (isset($_POST['type'])) {
            
            if( !estUneChaine($_POST['type'])) {
                $alerte = "Le type du capteur doit ètre une chaine de caractère.";
                
            } else {
                
                $liste = rechercheParType($bdd, $table, $_POST['type']);
                
                if(empty($liste)) {
                    $alerte = "Aucun capteur ne correspond à  votre recherche";
                }
            }
        }
        
        break;
        
    default:
        // si aucune fonction ne correspond au paramÃ¨tre function passÃ© en GET
        $vue = "erreur404";
        $title = "error404";
        $message = "Erreur 404 : la page recherchÃ©e n'existe pas.";
}

include ('header.php');
//include ('vues/' . $vue . '.php');
include ('footer.php');

