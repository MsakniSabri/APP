<!DOCTYPE html>
			
<html>

	<head>
		<meta charset="utf-8"/>
		<title>Connexion</title>
		<link rel="stylesheet" href="CSS/modifNFO.css">
	</head>

	<body>
		<?php include("header.php"); ?>

		<?php if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0 || $_SESSION['typeUtilisateur'] = 2) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
			header("Location: index.php");
		} ?>

	    <div id="modif">
	  		<section>
	  			<form action="modifINFOtest.php" id="login" method="post">
	  				<legend>Modification infos</legend>
		  			<fieldset>
		  				<div class="labelInput">

		  					<label> Nouveau nom </label>
							<input class="inputText" type="text" name="nom" placeholder="Dupont" onblur="verifRempliLettre(this)">

						</div>
						<span class="tooltip"> Nom incorrect </span>

						<div class="labelInput">

							<label> Nouveau prenom </label>
							<input class="inputText" type="text" name="prenom" placeholder="tintin" onblur="verifRempliLettre(this)"> 
		  					
		  				</div>
		  				<span class="tooltip"> Prenom incorrect </span>
							
					</fieldset>

					<fieldset>

						<div class="labelInput">
							<label> Nouveau mail </label>
							<input class="inputText" type="text" name="mail" placeholder="tintin.dupont@yopmail.com" onblur="verifMail(this)">
						</div>
						<span class="tooltip"> Mail incorect </span>
						
						<div class="labelInput">
							<label> Nouveau telephone </label>
							<input class="inputText" type="number" name="phone" placeholder="06" onblur="verifTel(this)">
						</div>
						<span class="tooltip"> Telephone incorect </span>

					</fieldset>

					<fieldset>

						<div class="labelInput">
							<label> Nouveau pays </label>
							<input class="inputText" type="text" name="pays" placeholder="france" onblur="verifRempliLettre(this)">
						</div>
						<span class="tooltip"> Pays incorrect </span>

						<div class="labelInput">
							<label> Nouvelle ville </label>
							<input class="inputText" type="text" name="ville" placeholder="paris" onblur="verifRempliLettre(this)">
						</div>
						<span class="tooltip"> Ville incorrecte </span>

						<div class="labelInput">
							<label> Code postal </label>
							<input class="inputText" type="number" name="zip" placeholder="92" onblur="verifZIP(this)">
						</div>
						<span class="tooltip"> code postal de 5 chiffres svp </span>

						<div class="labelInput">
							<label> Nouvelle adresse </label>
							<input class="inputText" type="text" name="adresse" placeholder="2 rue de la pompe" onblur="verifAdresse(this)">
						</div> 
						<span class="tooltip"> adresse incorect </span>
						
					</fieldset>

						<?php if (isset($_COOKIE['infos'])) {?>
							<legend><?= $_COOKIE['infos']; ?> </legend>
							
						<?php } ?>

					<fieldset class="validif">
						<input class="inputText" type="submit" name="validation" value="Changer">
					</fieldset>

				</form>
				
	   		</section>
	   		<script type="text/javascript" src="javascript/verifForm.js"></script>
		</div>

	    <?php include("footer.php"); ?>


	</body>

</html>