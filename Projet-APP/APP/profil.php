<!DOCTYPE html>

<html>

	<head>
		<title>Profil</title>
		<link rel="stylesheet" href="CSS/profil.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<body>
		<?php include("header.php");

		if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0 || $_SESSION['typeUtilisateur'] = 2) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
			header("Location: index.php");
		}

		//Connexion à la BDD

		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e)
		{
			die('erreur:'.$e -> getMessage()); //Affiche un message en cas d'erreur
		}
		if (isset($_GET['profileid'])) {  //Si l'utilisateur a taper une ID dans l'url
			$currentid = $_GET['profileid'];
		} else {
			header("Location:profil.php?profileid=".urlencode($_SESSION['id']));
		}
		$req = $bdd -> query("SELECT id,nom,prenom,mail,adresse,phone,ZIP,imageProfile FROM compte WHERE id='$currentid'");
		$req -> execute(array('id' => $_SESSION['id']));
		$profil = $req->fetch();


		?>
		<div class="affichage">
			<div class="menuProfil1">
				<a href="profil.php?profileid=<?php echo $currentid ?>">Profil</a>
				<a href="tests.php?profileid=<?php echo $currentid ?>">Tests</a>
			</div>
			<?php if ($req->rowCount() > 0) {  ?>
			<div class="infos">
				<div class="col-2-2">
					<!-- C'est pour afficher l'image de l'utilisateur -->
					<?php
					if($profil['imageProfile']==''){
						echo "<img width='280' height='280' src='imageProfile/Emptyprofile.png'>";
					}
					else{
						echo "<img width='280' height='280' src='imageProfile/".$profil['imageProfile']."' alt='Profile Pic'>";
					}
					?>
					<?php
							if (($profil['id'] == $_SESSION['id'])) {	?>
					<form action="" method="post" enctype="multipart/form-data">
						<input type="file" name="file">
						<input type="submit" name="submit" value="confirmer">
					</form>
				<?php } ?>
				</div>
				<div>
					<p><strong>Nom:</strong> <?php echo $profil['nom']?></p>
					<p><strong>Prénom:</strong>  <?php echo $profil['prenom']?> </p>
					<p><strong>Adresse Mail:</strong> <?php echo $profil['mail']?></p>
					<p><strong>Adresse:</strong> <?php echo $profil['adresse']?></p>
					<p><strong>Code Postal:</strong> <?php echo $profil['ZIP']?></p>
					<p><strong>Numéro tel:</strong> <?php echo $profil['phone']?></p>
				</div>
			</div>
			<?php } else { //L'utilisateur a tapé l'ID d'un utilisateur qui n'existe pas ?>
			<div class="infos">
				<script type="text/javascript" src="javascript/errorprofile.js"></script>
			</div>
			<?php } ?>
			<?php
			if (($profil['id'] == $_SESSION['id'])) {	?>
			<div class="menuProfil2">
				<a href="modifINFO.php">MODIFIER MES INFORMATIONS PERSONNELLES</a>
				<a href="modifMDP.php">MODIFIER MON MOT DE PASSE</a>
			</div>
			<?php } ?>
		</div>

		<?php
        if(isset($_POST['submit'])){
        	if ($_FILES['file']['name']=="") {
        		header("Refresh:0");
        	}
        	else{
        		move_uploaded_file($_FILES['file']['tmp_name'],"imageProfile/".$_FILES['file']['name']);
                $req = $bdd -> query("UPDATE compte SET imageProfile = '".$_FILES['file']['name']."' WHERE id = '".$_SESSION['id']."'");
                header("Refresh:0");
        	}
        }
		?>
		<!-- Gère les sauts de ligne en fonction des profils -->
		<?php if (($profil['id'] == $_SESSION['id'])) {	?>
		<div class="saut">
			
		</div>
		<?php
		}
		?>
		<?php if(($profil['id'] != $_SESSION['id'])){?>
		<div class ="sautAutre">
		</div>
		<?php
		}
		?>


		<?php include("footer.php"); ?>
	</body>

</html>
