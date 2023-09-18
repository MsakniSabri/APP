<!DOCTYPE html>

<html>

	<head>
		<title>Recherche</title>
		<link rel="stylesheet" href="CSS/search.css">
	</head>

	<body>
		<!-- comment -->

		<body>
			<header>
				<?php include("header.php"); ?>
			</header>


			<?php
			//Connexion à la BDD
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch(Exception $e)
			{
				die('erreur:'.$e -> getMessage()); //Affiche un message en cas d'erreur
			}
			?>


			<div id="conteneur">
				<?php

				if (isset($_GET['searchtext'])) {  //Si l'utilisateur a effectué une recherche

					$searchquery = htmlspecialchars($_GET['searchtext']);
					$category = htmlspecialchars($_GET['category']);

					if ($category == '0') {	//FAQ

						$result = $bdd->prepare("SELECT * FROM faq WHERE question LIKE :searchquery OR reponse LIKE :searchquery ORDER BY ID DESC ");
						$result -> execute(array('searchquery' => '%'.$searchquery.'%','searchquery' => '%'.$searchquery.'%'));

						if ($result->rowCount() > 0) { //Si au moins 1 résultat a été trouvé
							while ($donnees = $result->fetch()){?>
								<div>

									<legend>
										<strong> Question <?php echo $donnees['id']?>: </strong>
									</legend>

									<!-- question -->
									<p>
										<?php echo $donnees['question']?>
									</p>
									

									<!-- reponses-->
									<p>
										<?php echo $donnees['reponse']?>
									</p>
								</div>
						<?php
							}
						} else { //Aucun résultat 	 ?>
								<p>Aucun résultat.</p>
					<?php
						}
					}
					if ($category == '1') {	//profil

						$result = $bdd->prepare("SELECT * FROM compte WHERE nom LIKE :searchquery OR prenom LIKE :searchquery ORDER BY ID DESC");
						$result -> execute(array('searchquery' => '%'.$searchquery.'%','searchquery' => '%'.$searchquery.'%'));

						if ($result->rowCount() > 0) { //Si au moins 1 résultat a été trouvé
							while ($donnees = $result->fetch()){?>
								<div>
									<!-- comptes -->
									<p>
									<strong>Utilisateur n°<?php echo $donnees['id']?>:</strong> <a href="profil.php?profileid=<?php echo $donnees['id'] ?> "><?php echo $donnees['prenom'].' '.$donnees['nom']?></a>
									</p>

								</div>
								<?php
							}
						} else { //Aucun résultat 	 ?>
								<p>Aucun résultat.</p>
		<?php		}
					}
					if ($category == '2') {	//test

						$result = $bdd->prepare("SELECT * FROM tests INNER JOIN compte WHERE (compte.id = tests.id_examine) AND (compte.nom LIKE :searchquery OR compte.prenom LIKE :searchquery) ORDER BY ID DESC ");
						$result -> execute(array('searchquery' => '%'.$searchquery.'%','searchquery' => '%'.$searchquery.'%'));
						
						if ($result->rowCount() > 0) { //Si au moins 1 résultat a été trouvé
							while ($donnees = $result->fetch()){
								?>
								<div>
									<!-- tests -->
									<p>
									<a href="tests.php?profileid=<?php echo $donnees['id_test'] ?> "><strong>Test n°<?php echo $donnees['id_test']?>:</strong></a> <a href="profil.php?profileid=<?php echo $donnees['id'] ?> "><?php echo $donnees['prenom'].' '.$donnees['nom']?></a>
									</p>

								</div>
								<?php
							}
						} else { //Aucun résultat 	 ?>
								<p>Aucun résultat.</p>
		<?php		}
					}
				} ?>
			</div>


			<div class="saut">
				
			</div>
			<footer>
				<?php include("footer.php"); ?>
			</footer>

		</body>




	</body>

</html>