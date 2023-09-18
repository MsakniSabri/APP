<!DOCTYPE html>

<html>

	<head>
		<title>Profil</title>
		<link rel="stylesheet" href="CSS/profil.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	</head>

	<body>
		<div id="container">
			<?php include("header.php");

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
				$currentid = htmlspecialchars($_GET['profileid']);
			} else {
				header("Location:tests.php?profileid=".urlencode($_SESSION['id']));
			}




			?>
			<div class="affichage">
				<div class="menuProfil1">
					<a href="profil.php?profileid=<?php echo $currentid ?>">Profil</a>
					<a href="tests.php?profileid=<?php echo $currentid ?>">Tests</a>
				</div>
				<div class="infos">
					<div class="col-2-2">
						<!-- C'est pour afficher l'image de l'utilisateur -->
						<?php
						$req = $bdd -> query("SELECT 	imageProfile FROM compte WHERE id='$currentid'");
						$req -> execute(array('id' => $_SESSION['id']));
						$profil = $req->fetch();
							if($profil['imageProfile']==''){
								echo "<img width='280' height='280' src='imageProfile/Emptyprofile.png'>";
							}
							else{
								echo "<img width='280' height='280' src='imageProfile/".$profil['imageProfile']."' alt='Profile Pic'>";
							}
						?>
					</div>
					<div class="liste_tests">
						<?php
						if ($currentid == $_SESSION['id']){ //sur son profil?>
							<legend><p><b>Mes tests</b><p></legend>
													<div>
						<?php include("graph.php"); ?>
					</div>
	<?php			} else { //sur le profil de qqun dautre
							$req = $bdd->prepare("SELECT * FROM compte WHERE id = :id");
							$req -> execute(array("id" => $currentid));
							$utilisateur = $req -> fetch();
							if ($req->rowCount() > 0) { ?>
								<legend><p><b>Liste des tests de <?php echo $utilisateur['prenom'].' '.$utilisateur['nom']?></b><p></legend>
									<?php include("graph.php"); ?>
								</div>
								<?php if ($_SESSION['typeUtilisateur']<2) { ?>
									<div>
										<a href="ajoutTest.php">Ajouter un test</a>
								    </div>
								<?php } ?>
<?php 				} else { //L'utilisateur a tapé l'ID d'un utilisateur qui n'existe pas ?>
								<div class="infos">
								</div>
<?php						}
		}
						?>
</div>
					</div>
					<div class="sautTest">
					</div>


			
		</div>
		<?php include("footer.php"); ?>
	</body>

</html>
