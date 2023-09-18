<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Bienvenue</title>
	<link rel="stylesheet" href="CSS/main.css">
</head>
<body>
	<?php include("header.php"); ?>

	<?php if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
			header("Location: index.php");
		} ?>

	<section>
		<link rel = "stylesheet" href="CSS/saisie.css">

		<?php
		//on essaie e se connecter a la bdd, s'il y a une erreur on affiche juste une erreur au lieu d'afficher le lien vers la bdd par securité
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e)
		{
			die('erreur:'.$e -> getMessage());
		}
		?>
		<?php

		//on remplis les infos
		$mail = htmlspecialchars($_POST['mail']);
		$resultat = htmlspecialchars($_POST['resultat']);
		$score = htmlspecialchars($_POST['score']);
		$date = htmlspecialchars($_POST['date']);
		$id_examinateur = htmlspecialchars($_SESSION['id']);

		//on cherche le mail dans la base de donné pour recuperer l'id de la personne examinée
		$req = $bdd->prepare('SELECT id FROM compte WHERE mail=:mail');
		$req -> execute(array('mail' => $mail));
		$mailBDD = $req->fetch();

		//on test si mail est bien present dans la bdd
		if (isset($mailBDD['id'])) {
			echo "le mail est present";
			$id_examine=$mailBDD['id'];

			//on insert les info dans la table test
			$req = $bdd->prepare(' INSERT INTO tests(id_examinateur, id_examine, date, resultat, score) VALUES (:id_examinateur, :id_examine, :date, :resultat, :score)');
			$req -> execute(array(
			'id_examinateur' => $id_examinateur,
			'id_examine'=> $id_examine,
			'date'=> $date,
			'resultat'=> $resultat,
			'score'=> $score));
			echo "<br>";
			echo 'Votre test a été ajouté avec succès!';
			mail($mail, "resultat du test", "resultat:".$resultat." score: ".$score);
			header("Location:tests.php");
		}
		//s'il n'est pas present, le mail est erroné
		else{
			echo "le mail est erroné";
			setcookie("mail",$mail,time()+200);
			setcookie("date",$date,time()+200);
			setcookie("resultat",$resultat,time()+200);
			setcookie("score",$score,time()+200);

			header("Location:ajoutTest.php");
	    }



			/*
   			ini_set( 'display_errors', 1 );
    		error_reporting( E_ALL );

   			$motPasseProvisoire = "Xa123§wY";

    		$subject = "Votre mot de passe provisoire pour vous connecter sur Psitech";
 			$message = "Vous venez de vous inscrire sur le site de Psitech. Voici votre mot de passe provisoire : ".$motPasseProvisoire." \n Vous devrez le changer lors de la première connexion. \n L'équipe Psitech";

    		mail($mail,$subject,$message);

   			echo "L'email a été envoyé.";

			//on redirige
			header("Location: index.php");

			*/

			?>
			</p>
		</section>
	<?php include("footer.php"); ?>

</body>
