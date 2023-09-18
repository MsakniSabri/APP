<!DOCTYPE html>



<html>

	<head>
		<meta charset="utf-8"/>
		<title>Connexion</title>
		<link rel="stylesheet" href="CSS/login.css">
	</head>

	<body>
		<?php include("header.php"); ?>



	    <div class="login">

					<h1>Bienvenue ! Connectez-vous ici </h1>


<?php 		if (isset($_GET['error']) && ($_GET['error']) == 1) { //Message d'erreur ?>
					<h4 style="color:red;">Mot de passe ou email erronés</h4>
<?php			}?>
	  		<section>

	  			<form action="loginTest.php" id="login" method="post">
	  				<!-- <legend>Login</legend> -->
	  			<div class="inputinfo">

		  			<fieldset>
						<label>
							Adresse e-mail* <input type="text" name="mail" id="mail" placeholder="exemple@gmail.com" required>
						</label>
					</fieldset>

					<fieldset class="account_info">
						<label>
							Mot de passe* <input type="password" name="mdp" id="password" placeholder="*****" required>
						</label>
					</fieldset>
				</div>

				<div class="submitbut">
					<fieldset class="account_info">
						<input type="submit" name="remember" value="Se connecter" id="button">
					</fieldset>
				</div>


				</form>
	   		</section>
		</div>

		<div id="loginquestion">
			<p id="loginquestion">
				Vous n'avez pas de compte ?
			</p>
			<p id="loginquestion">
				Demandez à un admin de vous créer un compte <a href="contactus.php">Juste ici !</a>
			</p>
		</div>




	    <?php include("footer.php"); ?>


	</body>

</html>

</html>
