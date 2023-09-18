<?php session_start();
//on essaie e se connecter a la bdd, s'il y a une erreur on affiche juste une erreur au lieu d'afficher le lien vers la bdd par securité
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	die('erreur:'.$e -> getMessage());
}

//on affiche le résultat du formulaire
echo '<p>$_POST[mail] :    '.$_POST['mail'].'</p>';
echo '<p>$_POST[mdp] :   '.$_POST['mdp'].'</p>';
echo "<p>-----------------------------------</p>";


//on recupere le mdp associé au mail (s'il existe)
$req = $bdd -> prepare('SELECT * FROM compte WHERE mail=:mail');
$req -> execute(array('mail' => $_POST['mail']));
$idBDD = $req->fetch();

//si on a trouvé un compte on verifie que le mdp entré est le bon et on le connecte
if (isset($idBDD['id']) && (password_verify($_POST['mdp'], $idBDD['mdp']) || $_POST['mdp'] == $idBDD['mdp'])) {
	$_SESSION['id'] = $idBDD['id'];
	header("Location:index.php");
}
else{
	header("Location:login.php?error=1");
}


$req->closeCursor();

?>
