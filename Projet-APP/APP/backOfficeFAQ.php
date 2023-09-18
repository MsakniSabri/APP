<!DOCTYPE html>

<html lang="fr">

	<head>
		<title>Psitech</title>
		<link rel="stylesheet" href="CSS/backOfficeFAQ.css">
	</head>

	<body>
		<?php include("header.php");?>

		<?php if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
			header("Location: index.php");
		} ?>

		<?php if (isset($_POST['action'])) { //action demandée

			$action = $_POST['action'];
			if ($action == "ajouter") {
				$req = $bdd->prepare('INSERT INTO FAQ (question, reponse) VALUES(:question, :reponse)');
				$req -> execute(array(
					'question' => $_POST['ajouterQ'],
					'reponse' => $_POST['ajouterR']
					));

					?>
					<script type="text/javascript">
						alert("Question ajoutée")
					</script> <?php
			}
			if ($action == "annuler" && isset($_COOKIE['action']) && isset($_COOKIE["arrayChangementsSerialise"]) && $_COOKIE['action'] != 'annuler'){ //on veut annuler

				$AnciennesValeurs = unserialize($_COOKIE["arrayChangementsSerialise"]);
				$actionPrecedente = $_COOKIE["action"];


				if ($actionPrecedente == 'supprimer') {
					$req = $bdd->prepare('INSERT INTO FAQ (id, question, reponse) VALUES(:id, :question, :reponse)');

				}
				else {
					$req = $bdd->prepare('UPDATE FAQ SET
						id = :id,
						question = :question,
						reponse = :reponse
						WHERE id = :id');
				}
				foreach ($AnciennesValeurs as $key => $value) {
					if (!is_null($value['reponse'])) {

						$req -> execute(array(
							'id' => $value['id'],
							'question' => $value['question'],
							'reponse' => $value['reponse']
						));
					}
				}
			setcookie("action", $action, time() + 7*24*60*60);
					?>
					<script type="text/javascript">
						alert("Modifications annulées")
					</script>
					<?php
					}
			else{
				if($action == "supprimer"){//on prepare la commande pour supprimer les comptes

					$FAQsuppression = $bdd->prepare('DELETE FROM Faq WHERE id = :id');

					$arrayChangements = array();
					$infosActuelles =$bdd -> prepare('SELECT * FROM FAQ WHERE id = :id');

					foreach ($_POST as $idKey => $value) {//on recupere les infos qui sont stockés avant de les supprimer puis on supprime

						$infosActuelles -> execute(array('id' => $idKey));
						$arrayInfos = $infosActuelles -> fetch();
						$arrayChangements[] = $arrayInfos;

						$FAQsuppression -> execute(array('id' => $idKey));
					}

				$arrayChangementsSerialise = serialize($arrayChangements);

				?>
				<script type="text/javascript">
					alert("Questions supprimées")
				</script>
				<?php
				setcookie("action", $action, time() + 7*24*60*60);
				setcookie("arrayChangementsSerialise", $arrayChangementsSerialise, time() + 7*24*60*60);

				}
			if($action == "modifier"){

					function supEspaces(string $string)
				    {//créer une chaine de caractère aléatoire avec minuscules, majuscules, chiffres (parfait pour des mdp aléatoire)
				        while ($string[0]==" ") {
				            $string = substr($string, 1, strlen($string));
				        }
				        while ($string[strlen($string)-1]==' ') {
				            $string = substr($string, 0, strlen($string)-2);
				        }
				        return $string;
				    }

					$FAQmodification = $bdd->prepare('UPDATE Faq SET question = :question, reponse = :reponse WHERE id = :id');

					$arrayChangements = array();
					$infosActuelles = $bdd -> prepare('SELECT * FROM FAQ WHERE id = :id');
					$ids = $bdd->query('SELECT id FROM faq ORDER BY id LIMIT 0,20');

					while ($id = $ids -> fetch() ) {//on parcours les ids pour voir les questions selectionnées
						$id = $id['id'];
					 	if (isset($_POST[$id]) && $_POST[$id]) {//si la question a été selectionée on la modifie
					 		if ($_POST['question'.$id][0] == " ") {//on supprimme les espaces au debut de la question
					 			$_POST['question'.$id] = supEspaces($_POST['question'.$id]);
					 		}
					 		if ($_POST['reponse'.$id][0] == " ") {//idem pour la reponse
					 			$_POST['reponse'.$id] = supEspaces($_POST['reponse'.$id]);
					 		}

					 		$infosActuelles -> execute(array('id' => $id));
							$arrayInfos = $infosActuelles -> fetch();
							$arrayChangements[] = $arrayInfos;

					 		$FAQmodification -> execute(array('id' =>$id, 'question' =>$_POST['question'.$id], 'reponse' =>$_POST['reponse'.$id]));
					 	}
					}

				$arrayChangementsSerialise = serialize($arrayChangements);

				 ?>
				 <script type="text/javascript">
					 alert("Les questions ont été modifiées")
				 </script><?php
				setcookie("action", $action, time() + 7*24*60*60);
				setcookie("arrayChangementsSerialise", $arrayChangementsSerialise, time() + 7*24*60*60);
				}
			}
		}?>
		<h3>Gestion FAQ</h3>
<!-- affichages des questions et de la barre de navigation -->
		<?php
		if ( isset($_GET['nav']) ) {
			$premiereQuestion = $_GET['nav'];
		}
		else{
			$premiereQuestion = 0;
		}

		$FAQ = $bdd->query('SELECT * FROM faq ORDER BY id LIMIT '.$premiereQuestion.',5') ?>

		<form method="post" action="backOfficeFAQ.php">

			<?php while ( $QR = $FAQ ->fetch() ) { ?>

				<div>
					<input type="checkbox" <?= 'name='.$QR['id'];?> >
					<textarea rows="1" cols="60" <?= 'name=question'.$QR['id'];?> > <?= $QR['question']; ?> </textarea>
					<textarea rows="1" cols="60" <?= 'name=reponse'.$QR['id'];?> > <?= $QR['reponse']; ?> </textarea>
				</div>

			<?php } ?>

			<br/>
			<button name="action" type="submit" value="modifier">Modifier</button>
			<button name="action" type="submit" value="supprimer">Supprimer</button>
			<button name="action" type="submit" value="annuler">Annuler</button>
		</form>

		<?php
		$nbrQuestions = $bdd->query ('SELECT COUNT(*) as nbq FROM FAQ');
		$nbrQuestions = $nbrQuestions ->fetch();
		$nbrQuestions = $nbrQuestions['nbq'];
		?>

		<div style="margin-top:2px;">
			<b>Pages :</b>
			<?php
			for ($i=0; $i < $nbrQuestions ; $i+=5) {?>
				<a href="backOfficeFAQ.php?<?="nav=".$i ?> " > <?= ($i/5)+1 ?></a>
			<?php } ?>
		</div>

		<form method="post" action="backOfficeFAQ.php" style="margin-bottom:25px;">
				<label>
					<h2 style="margin-bottom: 9px; margin-top: 9px;">Ajouter une question</h2>
					<input type="text" name="ajouterQ" id="prenom" placeholder="Question" required>
					<input type="text" name="ajouterR" id="prenom" placeholder="Réponse" required>
				</label>
				<button name="action" type="submit" value="ajouter">Ajouter</button>
		</form>




		<div class="saut">

		</div>
	</div>
        <?php include("footer.php"); ?>
	</body>

</html>
