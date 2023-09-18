<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Bienvenue</title>
	<link rel="stylesheet" href="CSS/main.css">
</head>
<body>
<header>
			<?php include("header.php"); ?>
		</header>
		<section>
			<h1> Cr&eacute;ation du compte </h1>
			<p> Voici les informations saisies : </p>
			<p>
				<link rel = "stylesheet" href="CSS/saisie.css">

<?php
			//on essaie e se connecter a la bdd, s'il y a une erreur on affiche juste une erreur au lieu d'afficher le lien vers la bdd par securité
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '');
			}
			catch(Exception $e)
			{
				die('erreur:'.$e -> getMessage());
			}
			?>

<?php 
try
{
	if(isset($_POST['mail']))
	{
		$mail = $_POST['mail'];
	}
	else
	{
		$mail = 'NR';
	}
	if(isset($_POST['birthday']))
	{
		$dateNaissance = $_POST['birthday'];
	}
	else
	{
		$dateNaissance = "1900-01-01";
	}
	if(isset($_POST['phone']))
	{
		$numeroTelephone = $_POST['phone'];
	}
	else
	{
		$numeroTelephone = 123456789;
	}
	if(isset($_POST['last_name']))
	{
		$nom = $_POST['last_name'];
	}
	else
	{
		$nom = 'NR';
	}
	if(isset($_POST['prenom']))
	{
		$prenom = $_POST['prenom'];
	}
	else
	{
		$prenom = 'NR';
	}
	if(isset($_POST['sex']))
	{
		$sexe = $_POST['sex'];
	}
	else
	{
		$sexe = 'NR';
	}
	if(isset($_POST['country']))
	{
		$pays = $_POST['country'];
	}
	else
	{
		$pays = 'NR';
	}
	if(isset($_POST['town']))
	{
		$ville = $_POST['town'];
	}
	else
	{
		$ville = 'NR';
	}
	if(isset($_POST['ZIP']))
	{
		$codePostal = $_POST['ZIP'];
	}
	else
	{
		$codePostal = 12345;
	}
	if(isset($_POST['adress']))
	{
		$adresse = $_POST['adress'];
	}
	else
	{
		$adresse = 'NR';
	}
	if(isset($_POST['adress2']))
	{
		$complementAdresse = $_POST['adress2'];
	}
	else
	{
		$complementAdresse = 'NR';
	}
	if(isset($_POST['typeUtilisateur']))
	{
		$typeUtilisateur = $_POST['typeUtilisateur'];
	}
	else
	{
		$typeUtilisateur = 'NR';
	}

	echo 'mail =', $mail, '='; 
	echo "<br>";
	echo 'dateNaissance =', $dateNaissance, '='; 
	echo "<br>";
	echo 'numeroTelephone =', $numeroTelephone, '='; 
	echo "<br>";
	echo 'nom =', $nom, '='; 
	echo "<br>";
	echo 'prenom =', $prenom, '='; 
	echo "<br>";
	echo 'sexe =', $sexe, '='; 
	echo "<br>";
	echo 'pays =', $pays, '='; 
	echo "<br>";
	echo 'ville =', $ville, '='; 
	echo "<br>";
	echo 'codePostal =', $codePostal, '='; 
	echo "<br>";
	echo 'adresse =', $adresse, '='; 
	echo "<br>";
	echo 'complementAdresse =', $complementAdresse, '='; 
	echo "<br>";
	echo 'typeUtilisateur =', $typeUtilisateur, '='; 
	echo "<br>";
}
catch(Exception $e)
{
	die('erreur:'.$e -> getMessage());
}
try{
	
	$req = $bdd->prepare(' INSERT INTO compte4 (mail, dateNaissance, numeroTelephone, nom, prenom, sexe, pays, ville, codePostal, adresse, complementAdresse, typeUtilisateur) VALUES (:mail, :dateNaissance, :numeroTelephone, :nom, :prenom, :sexe, :pays, :ville, :codePostal, :adresse, :complementAdresse, :typeUtilisateur) ');
	$req->bindParam(':mail', $mail);
	$req->bindParam(':dateNaissance', $dateNaissance);
	$req->bindParam(':numeroTelephone', $numeroTelephone);
	$req->bindParam(':nom', $nom);
	$req->bindParam(':prenom', $prenom);
	$req->bindParam(':sexe', $sexe);
	$req->bindParam(':pays', $pays);
	$req->bindParam(':ville', $ville);
	$req->bindParam(':codePostal', $codePostal);
	$req->bindParam(':adresse', $adresse);
	$req->bindParam(':complementAdresse', $complementAdresse);
	$req->bindParam(':typeUtilisateur', $typeUtilisateur);
	$bdd->beginTransaction();
	$req->execute();
	$bdd->commit();

	echo "<br>";
	echo 'Votre compte a été créé avec succès!';

}
catch (Exception $e){
	die('erreur:'.$e -> getMessage());
}?>

<?php
 
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
 
    $motPasseProvisoire = "Xa123§wY";
 
    $subject = "Votre mot de passe provisoire pour vous connecter sur Psitech";
 	$message = "Vous venez de vous inscrire sur le site de Psitech. Voici votre mot de passe provisoire : ".$motPasseProvisoire." \n Vous devrez le changer lors de la première connexion. \n L'équipe Psitech" ;
    mail($mail,$subject,$message);
 
    echo "L'email a été envoyé.";
?>

</p>
</section>
		<footer>
			<?php include("footer.php"); ?>
		</footer>
</body>