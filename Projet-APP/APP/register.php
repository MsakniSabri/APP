<!DOCTYPE html>

<html lang="fr">

	<head>
		<title>Créer un compte</title>
		<link rel="stylesheet" href="CSS/register.css">
	</head>

	<body>

		<?php include("header.php"); ?>

		<?php
		if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0) ) ) {
			header("Location: index.php");
		}
		?>

	    <div class="form">
	  		<section>

	  			<form name="inscription" method="post" action="registerTest.php">
	  				
			  		<legend><h3>Création d'un nouveau compte</h3></legend>

		  			<fieldset>

			  			<?php if (isset($_COOKIE['infos'])) {
			  				echo "<p class='infosMalRemplies'> Les informations n'ont pas toutes été bien remplies. </p>";
			  			} ?>

		  				<div class="labelInput">

		  					<label> Nom </label>
							<input class="textInputs" type="text" name="nom" placeholder="Dupont" onblur="verifRempliLettre(this)"
								<?php if (isset($_COOKIE['nom'])) {
									echo "value = ".$_COOKIE['nom'];
								} ?>
							>

						</div>
						<span class="tooltip"> Nom incorrect </span>

						<div class="labelInput">

							<label> Prenom </label>
							<input class="textInputs" type="text" name="prenom" placeholder="tintin" onblur="verifRempliLettre(this)"
								<?php if (isset($_COOKIE['prenom'])) {
									echo "value = ".$_COOKIE['prenom'];
								} ?>
							> 
		  					
		  				</div>
		  				<span class="tooltip"> Prenom incorrect </span>
							
					</fieldset>

					<fieldset class="radios">
						<label class="radio"><input class="inputRadio" type="radio" name="genre" value="1" required
							<?php if (isset($_COOKIE['genre']) and $_COOKIE['genre']==1) { echo "checked";} ?>
							>Homme</label>
						<label class="radio"><input class="inputRadio" type="radio" name="genre" value="0"
							<?php if (isset($_COOKIE['genre']) and $_COOKIE['genre']==0) { echo "checked";} ?>
							>Femme</label>
						<label class="radio"><input class="inputRadio" type="radio" name="genre" value="2"
							<?php if (!isset($_COOKIE['genre']) || $_COOKIE['genre']==2) {echo "checked";} ?>
							>Autre</label>
					</fieldset>

					<fieldset>
						<div class="labelInput">
							<label>Date de naissance</label>
							<input class="textInputs" type="date" name="birthday" id="birthday" placeholder="01/01/2000" required
							<?php if (isset($_COOKIE['birthday'])) {
								echo "value = ".$_COOKIE['birthday'];
							} ?>
						> 
						</div>
						<span class="tooltip">Vous devez remplir votre date de naissance</span>
					</fieldset>

					<fieldset>

						<?php
			  			if (isset($_COOKIE['mail'])) {

			  				$mail = $bdd->prepare("SELECT * FROM compte WHERE mail = :mail");
			  				$mail -> execute(array('mail' => htmlspecialchars($_COOKIE['mail']) ));
			  				$mail = $mail -> fetch();
			  				if (isset($mail['mail'])) {?>
			  					<p class="infosMalRemplies"> adresse mail deja prise </p>
			  				<?php }
			  			}
			  			?>

						<div class="labelInput">

							<label> Mail </label>
							<input class="textInputs" type="text" name="mail" placeholder="tintin.dupont@yopmail.com" onblur="verifMail(this)"
								<?php if (isset($_COOKIE['mail'])) {
									echo "value = ".$_COOKIE['mail'];
								} ?>
							> 
						</div>
						<span class="tooltip"> Mail incorrect </span>
						
						<div class="labelInput">
							<label> Telephone </label>
							<input class="textInputs" type="number" name="phone" placeholder="06" onblur="verifTel(this)"
								<?php if (isset($_COOKIE['phone'])) {
									echo "value = ".$_COOKIE['phone'];
								} ?>
							> 
						</div>
						<span class="tooltip"> Telephone incorrect </span>

					</fieldset>

					<fieldset>

						<div class="labelInput">
							<label> Pays </label>
							<input class="textInputs" type="text" name="pays" placeholder="france" onblur="verifRempliLettre(this)"
								<?php if (isset($_COOKIE['pays'])) {
									echo "value = ".$_COOKIE['pays'];
								} ?>
							> 
						</div>
						<span class="tooltip"> Pays incorrect </span>

						<div class="labelInput">
							<label> Ville </label>
							<input class="textInputs" type="text" name="ville" placeholder="paris" onblur="verifRempliLettre(this)"
							<?php if (isset($_COOKIE['prenom'])) {
								echo "value = ".$_COOKIE['prenom'];
							} ?>
						> 
						</div>
						<span class="tooltip"> ville incorrecte </span>

						<div class="labelInput">
							<label> Code postal </label>
							<input class="textInputs" type="number" name="ZIP" placeholder="92" onblur="verifZIP(this)"
								<?php if (isset($_COOKIE['ZIP'])) {
									echo "value = ".$_COOKIE['ZIP'];
								} ?>
							>
						</div>
						<span class="tooltip"> code postal de 5 chiffres svp </span>

						<div class="labelInput">
			
							<label> Adresse </label>
							<input class="textInputs" type="text" name="adresse" placeholder="2 rue de la pompe" onblur="verifAdresse(this)"
								<?php if (isset($_COOKIE['adresse'])) {
									echo "value = ".$_COOKIE['adresse'];
								} ?>
							>
						</div> 
						<span class="tooltip"> adresse incorrecte </span>
						
						<div class="labelInput">
							<label>Complement d'adresse</label>
							<input class="textInputs" type="text" name="adresse2" id="adresse2" placeholder="Complement d'adresse"
								<?php if (isset($_COOKIE['adresse2'])) {
									echo "value = ".$_COOKIE['adresse2'];
								} ?>
							>
						</div>
						

					</fieldset>

					<?php if ($_SESSION['typeUtilisateur']==2) {?>
						<fieldset class="radiosUtilisateur">
							<label class="radio"><input class="inputRadio" type="radio" name="typeUtilisateur" value="2" checked>Utilisateur</label>
							<label class="radio"><input class="inputRadio" type="radio" name="typeUtilisateur" value="1">Gestionnaire</label>
							<label class="radio"><input class="inputRadio" type="radio" name="typeUtilisateur" value="0">Administrateur</label>
						</fieldset>
					<?php } ?>

					<fieldset class="submitButton" >
						<input class="textInputs" type="submit" name="submit" value="S'inscrire">
					</fieldset>

				</form>

	   		</section>


		</div>

		<script type="text/javascript" src="javascript/verifForm.js"></script>
		
		<?php include("footer.php"); ?>


	</body>

</html>
