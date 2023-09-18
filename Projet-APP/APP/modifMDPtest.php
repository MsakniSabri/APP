<?php
session_start();
// On s amuse à créer quelques variables de session dans $_SESSION

if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0 || $_SESSION['typeUtilisateur'] = 2) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
	header("Location: index.php");
}

//on essaie e se connecter a la bdd, s'il y a une erreur on affiche juste une erreur au lieu d'afficher le lien vers la bdd par securité
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	die('erreur:'.$e -> getMessage());
}

//on affiche le resultat du formlaire
echo '<p>$_POST[mdp] :    '.$_POST['mdp'].'</p>';
echo '<p>$_POST[nmdp1] :   '.$_POST['nmdp1'].'</p>';
echo '<p>$_POST[nmdp2] :   '.$_POST['nmdp2'].'</p>';
echo '<p>$SESSION[mail] :   '.$_SESSION['mail'].'</p>';
echo "<p>-----------------------------------</p>";

if ($_POST['nmdp1']==$_POST['nmdp2']) {//si les nouveaus mdp sont pareils
	echo "<p>ils sont pareils</p>";

	$req = $bdd -> prepare('SELECT mdp FROM compte WHERE mail=:mail');
	$req -> execute(array('mail' => $_SESSION['mail']));
	$mdpBDD = $req->fetch();
	echo $mdpBDD['mdp'];

	if (password_verify($_POST['mdp'], $mdpBDD['mdp'])) {//si le mdp entré correspond au mdp hassé de la bdd on le modifie
		echo"<p> mdp entré == mdpBDD </p>";
		$req = $bdd -> prepare('UPDATE compte SET mdp = :nmdp WHERE mail = :mail');
		$req -> execute(array('mail' => $_SESSION['mail'],'nmdp' => password_hash($_POST['nmdp1'], PASSWORD_DEFAULT)));
		echo "<p>le mdp a bien ete changé</p>";
		header("Location:profil.php");
	}
	else{//le mot de passe est erroné
		echo "<p>le mot de passe n'est pas bon</p>";
		setcookie('mdp',$_POST['mdp'],time() + 600);
		setcookie('nmdp1',$_POST['nmdp1'],time() + 600);
		setcookie('nmdp2',$_POST['nmdp2'],time() + 600);
		header("Location:modifMDP.php");
	}
}
else{//les nouveaux mots de passe sont pas identiques
	echo "<p>ils ne sont pas pareils</p>";
	setcookie('mdp',$_POST['mdp'],time() + 600);
	setcookie('nmdp1',$_POST['nmdp1'],time() + 600);
	setcookie('nmdp2',$_POST['nmdp2'],time() + 600);
	header("Location:modifMDP.php");
}
/*
modifié pour mdp hassé


$req->closeCursor();
*/
?>
