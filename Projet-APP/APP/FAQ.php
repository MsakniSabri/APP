<!DOCTYPE html>

<html>

	<head>
		<title>FAQ</title>
		<link rel="stylesheet" href="CSS/faq.css">
	</head>

	<body>
		<!-- comment -->


		<body>
			<header>
				<?php include("header.php"); ?>
			</header>

			<h1 class="faqLel">
				Foire aux questions
			</h1>


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

				$questionsReponses = $bdd->query("SELECT * FROM faq ORDER BY ID DESC"); //Affiche toutes les questions dans la BDD, par ordre décroissant
					while ($donnees = $questionsReponses->fetch()){?>
						<div class="shape">
							<!-- question -->
							<a href="#" class="faqhelp">
								<strong>Question <?php echo $donnees['id']?>:</strong> <?php echo $donnees['question']?>
							</a>

							<!-- reponses-->
							<span class="faqhelp">
								<?php echo $donnees['reponse']?>
							</span>
								

						</div>
				<?php
					}

			 ?>
			</div>

			<footer>
				<?php include("footer.php"); ?>
			</footer>

		</body>




	</body>

</html>
