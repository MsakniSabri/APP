<?php
session_start();
// On s amuse à créer quelques variables de session dans $_SESSION

//on essaie e se connecter a la bdd, s'il y a une erreur on affiche juste une erreur au lieu d'afficher le lien vers la bdd par securité
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	die('erreur:'.$e -> getMessage());
}

$infosMisesAJour = false;

if (isset($_POST['nom']) and preg_match("#^[a-zA-Z]{2,}$#", $_POST['nom'])) {
	$req = $bdd -> prepare('UPDATE compte SET nom = :nom WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'nom' => $_POST['nom']));
	$infosMisesAJour = true;
}
if (isset($_POST['prenom']) and preg_match("#^[a-zA-Z]{2,}$#", $_POST['nom'])) {
 	$req = $bdd -> prepare('UPDATE compte SET prenom = :prenom WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'prenom' => $_POST['prenom']));
	$infosMisesAJour = true;
} 

//on test si le champ mail a ete remplie

if (isset($_POST['mail'])) {

	// on regarde si le format est correct cad : caractère@caractère.caractère
	if (preg_match("#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail']))
    {
    	//on test si le mail est deja present dans la bdd
		$req = $bdd -> prepare('SELECT mail FROM compte WHERE mail=:mail');
		$req -> execute(array('mail' => $_POST['mail']));
		$mailBDD = $req->fetch();

		//sil est deja present
		if (isset($mailBDD['mail']) and $mailBDD['mail']!="") {
			echo "mail deja pris";
			$mailPris=1;
		}
		//sil nest pas present on modifie
		else{
		
			$_POST['mail'] = htmlspecialchars($_POST['mail']);
			$req = $bdd -> prepare('UPDATE compte SET mail = :nouveauMail WHERE mail = :ancienMail');
			$req -> execute(array('ancienMail' => $_SESSION['mail'],'nouveauMail' => $_POST['mail']));
			$infosMisesAJour = true;
			
		}	
    }
    else
    {
      $mailInvalide=1;
    }
}


if (isset($_POST['phone']) and preg_match("#^[0-9]{10}$#", $_POST['phone'])) {
    $req = $bdd -> prepare('UPDATE compte SET phone = :phone WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'phone' => $_POST['phone']));
	$infosMisesAJour = true;
}
if (isset($_POST['pays']) and preg_match("#^[a-zA-Z]{2,}$#", $_POST['pays'])) {
 	$req = $bdd -> prepare('UPDATE compte SET pays = :pays WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'pays' => $_POST['pays']));
	$infosMisesAJour = true;
} 
if (isset($_POST['ville']) and preg_match("#^[a-zA-Z]{2,}$#", $_POST['ville'])) {
 	$req = $bdd -> prepare('UPDATE compte SET ville = :ville WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'ville' => $_POST['ville']));
	$infosMisesAJour = true;
} 
if (isset($_POST['ZIP']) and preg_match("#^[0-9]{5}$#", $_POST['ZIP'])) {
 	$req = $bdd -> prepare('UPDATE compte SET ZIP = :ZIP WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'ZIP' => $_POST['ZIP']));
	$infosMisesAJour = true;
} 
if (isset($_POST['adresse']) and preg_match("#^[0-9]{1,}[a-zA-Z0-9 ]{1,}$#", $_POST['adresse'])) {
 	$req = $bdd -> prepare('UPDATE compte SET adresse = :adresse WHERE mail = :mail');
	$req -> execute(array('mail' => $_SESSION['mail'],'adresse' => $_POST['adresse']));
	$infosMisesAJour = true;
}



if (isset($mailPris) && $mailPris==1) {
	setcookie("infos","Ce mail est déjà pris",time()+200);
	echo "mail faux";
	header("Location:modifINFO.php");
}
else if (isset($mailInvalide) && $mailInvalide==1){
	setcookie("infos","Cette adresse mail est invalide",time()+200);
	echo "mail faux";
	header("Location:modifINFO.php");
}
else if ($infosMisesAJour) {
	header("Location:profil.php");
}
else{
	header("Location:modifINFO.php");
}
?>
