<!DOCTYPE html>

<html lang="fr">

	<head>
		<title>Ajouter un test</title>
		<link rel="stylesheet" href="CSS/register.css">
	</head>

	<body>

		<?php include("header.php"); ?>

		<?php if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
			header("Location: index.php");
		} ?>

<p class="retour">
	<a href="profil.php">Retour</a>
</p>

	    <div class="modifTest">
	  		<section>
	  			<form name="inscription" method="post" action="ajoutTestTest.php">
			  		<legend><p>Ajout d'un test</p></legend>
			  		<div class="inputPos">
			  			<fieldset>
							<label>
								<p>Mail de la personne éxaminée</p>
								<input type="text" name="mail" placeholder="mail"
								<?php
								if (isset($_COOKIE["mail"])) {
								echo "value=".htmlspecialchars($_COOKIE["mail"]);
								} ?>
								required>
							</label>
							<?php
							if (isset($_COOKIE["mail"])) {
							echo "<legend>mail erroné</legend>";
							} ?>


						</fieldset>

						<fieldset>
							<label>
								<p>Résultat</p>
								<input type="number" name="resultat" placeholder="resultat"
								<?php
								if (isset($_COOKIE["resultat"])) {
								echo "value=".htmlspecialchars($_COOKIE["resultat"]);
								} ?>
								required>
							</label>
						</fieldset>

			  			<fieldset>
							<label>
								<p>Score</p>
								<input type="number" name="score" placeholder="score"
								<?php
								if (isset($_COOKIE["score"])) {
								echo "value=".htmlspecialchars($_COOKIE["score"]);
								} ?>
								required>
							</label>
						</fieldset>
					</div>
						<div class="datePos">
						<fieldset>
							<label>
								<p>Date</p>
								<input type="date" name="date"
								<?php
								if (isset($_COOKIE["date"])) {
								echo "value=".htmlspecialchars($_COOKIE["date"]);
								}
								else{
									echo "value=date('Y-m-d')";
								}?>>
							</label>
						</fieldset>
					</div>
					<div class="submitButton">
						<span>
							<input type="submit" name="submit" value="rajouter">
						</span>
					</div>
					<div class="saut">
					</div>
				</form>

	   		</section>


		</div>
		<footer>
			<?php include("footer.php"); ?>
		</footer>


	</body>

</html>
