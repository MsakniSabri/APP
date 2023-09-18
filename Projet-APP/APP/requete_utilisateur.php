<?php session_start(); 

// on rÃ©cupÃ¨re les requÃªtes gÃ©nÃ©riques
include('requetes.generiques.php');

//on dÃ©finit le nom de la table
$table = "users";

// requÃªtes spÃ©cifiques Ã  la table des capteurs


/**
 * Recherche un utilisateur en fonction du nom passÃ© en paramÃ¨tre
 * @param PDO $bdd
 * @param string $nom
 * @return array
 */
function rechercheParNom(PDO $bdd, string $nom): array {
    
    $statement = $bdd->prepare('SELECT * FROM  users WHERE username = :username');
    $statement->bindParam(":username", $value);
    $statement->execute();
    
    return $statement->fetchAll();
    
}

/**
 * RÃ©cupÃ¨re tous les enregistrements de la table users
 * @param PDO $bdd
 * @return array
 */
function recupereTousUtilisateurs(PDO $bdd): array {
    $query = 'SELECT * FROM users';
    return $bdd->query($query)->fetchAll();
}

/**
 * Ajoute un nouvel utilisateur dans la base de donnÃ©es
 * @param array $utilisateur
 */
function ajouteUtilisateur(PDO $bdd, array $utilisateur) {
    
    $query = ' INSERT INTO users (username, password) VALUES (:username, :password)';
    $donnees = $bdd->prepare($query);
    $donnees->bindParam(":username", $utilisateur['username'], PDO::PARAM_STR);
    $donnees->bindParam(":password", $utilisateur['password']);
    return $donnees->execute();
    
}

?>
