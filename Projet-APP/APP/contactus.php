<!DOCTYPE html>

<html>

	<head>
		<title>Contact</title>
		<link rel="stylesheet" href="CSS/contact.css">
	</head>

	<body>  
		<!-- comment -->
		

		<body>

			<?php include("header.php"); ?>

			<?php if (isset($_POST["nom"])) {
				$nom = htmlspecialchars($_POST["nom"]);
				$mail = htmlspecialchars($_POST["mail"]);
				$objet = htmlspecialchars($_POST["objet"]);
				$message = htmlspecialchars($_POST["message"]);

				if (mail("psitech.g3e@gmail.com", $objet ,$nom."<br/>".$mail."<br/>".$message )) {
					echo "email envoyé";
				}
				else{
					echo "erreur";
				}
				
			} ?>

			<div class="header">
				<h1>Nous contacter </h1>
			</div>
			
			
			<!-- Ce n'est pas la version définitive ! , c'est juste un aperçu de ce que pourrait être notre page contact us -->
			<!-- De toute façon il ne marche pas puisque les données ne sont transmises/stockées nulle part -->
			<div class="contact">

				<form action="contactus.php" method="post">

				  <div class="elem-group">

				    <label for="name">Votre nom</label>

				    <input type="text" id="name" name="nom" placeholder="Votre nom" pattern=[A-Z\sa-z]{3,20} required>

				  </div>

				  <div class="elem-group">

				    <label for="email">Votre e-mail</label>

				    <input type="email" id="email" name="mail" placeholder="votre@email.com" required>

				  </div>

				  <div class="elem-group">

				    <label for="title">Raison du ticket</label>

				    <input type="text" id="title" name="objet" placeholder="J'ai oublié mon mot de passe et mon nom d'utilisateur" pattern=[A-Za-z0-9\s]{3,60}>

				  </div>

				  <div class="elem-group">

				    <label for="message">Votre message</label>

				    <textarea id="message" name="message" placeholder="Votre message ici." required></textarea>

				  </div>

				  <button class ="button" type="submit">Envoyer le message</button>

				</form>
				
			</div>
			<div class="saut">
				<p></p>
			</div>
			<footer>
				<?php include("footer.php"); ?>
			</footer>
		</body>
	
	    


	</body>

</html>
