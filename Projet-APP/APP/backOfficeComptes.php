<!DOCTYPE html>

<html lang="fr">

	<head>
		<title>Psitech</title>
		<link rel="stylesheet" href="CSS/backOfficeComptes.css">
	</head>

	<body>
		<?php include("header.php");?>

		<?php if ( !( isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] = 1 ||  $_SESSION['typeUtilisateur'] = 0) ) ) { //on ne peut entrer sur le BO que si on en a lautoristion
			header("Location: index.php");
		} ?>

		<?php if (isset($_POST['action'])) {//action demandée

			$action = $_POST['action'];

			if ($action == "annuler" && isset($_COOKIE['action']) && isset($_COOKIE["arrayChangementsSerialise"])  && $_COOKIE['action'] != 'annuler'){ //on veut annuler

				$AnciennesValeurs = unserialize($_COOKIE["arrayChangementsSerialise"]);
				$actionPrecedente = $_COOKIE["action"];


				if ($actionPrecedente == 'supprimer') {
					$req = $bdd->prepare('INSERT INTO compte (id, mail, mdp, birthday, phone, nom, prenom, genre, pays, ville, ZIP, adresse, adresse2, typeUtilisateur) VALUES(:id, :mail, :mdp, :birthday, :phone, :nom, :prenom, :genre, :pays, :ville, :ZIP, :adresse, :adresse2, :typeUtilisateur)');

				}
				else {
					$req = $bdd->prepare('UPDATE compte SET
						id = :id,
						mail = :mail,
						mdp = :mdp,
						birthday = :birthday,
						phone = :phone,
						nom = :nom,
						prenom = :prenom,
						genre = :genre,
						pays = :pays,
						ville = :ville,
						ZIP = :ZIP,
						adresse = :adresse,
						adresse2 = :adresse2,
						typeUtilisateur = :typeUtilisateur
						WHERE id = :id');
				}
				foreach ($AnciennesValeurs as $key => $value) {
					if (!is_null($value['mail'])) {
						$req -> execute(array(
							'id' => $value['id'],
							'mail' => $value['mail'],
							'mdp' => $value['mdp'],
							'birthday' => $value['birthday'],
							'phone' => $value['phone'],
							'nom' => $value['nom'],
							'prenom' => $value['prenom'],
							'genre' => $value['genre'],
							'pays' => $value['pays'],
							'ville' => $value['ville'],
							'ZIP' => $value['ZIP'],
							'adresse' => $value['adresse'],
							'adresse2' => $value['adresse2'],
							'typeUtilisateur' => $value['typeUtilisateur']
						));
					}
				}

			echo "action faite: ".$action." ".$actionPrecedente;
			setcookie("action", $action, time() + 7*24*60*60);

			} else if ($action == "supprimer" || $action == "utilisateur" || $action == "modifier" ) {//si autre action que annuler tests pour eviter erreurs

				if($action == "supprimer"){//on prepare la commande pour supprimer les comptes
					$req = $bdd->prepare('DELETE FROM compte WHERE id = :id');
					$arrayChangements = array();
					$req2 =$bdd -> prepare('SELECT * FROM compte WHERE id = :id');
					foreach ($_POST as $idKey => $value) {
						$req2 -> execute(array('id' => $idKey));
						$arrayChangement = $req2 -> fetch();
						$arrayChangements[] = $arrayChangement;
						$req -> execute(array('id' => $idKey));
					}
					$arrayChangementsSerialise = serialize($arrayChangements);
				} else if ($action == "modifier") {//commande pour rendre utilisateur
					$Comptemodification = $bdd->prepare('UPDATE Compte SET typeUtilisateur = :typeUtilisateur WHERE id = :id');

					$arrayChangements = array();
					$infosActuelles = $bdd -> prepare('SELECT * FROM Compte WHERE id = :id');
					$ids = $bdd->query('SELECT id, typeUtilisateur FROM Compte ORDER BY id LIMIT 0,20');

					while ($id = $ids -> fetch() ) {//on parcours les ids pour voir les comptes selectionnés
						$id = $id['id'];
						if (isset($_POST[$id]) && $_POST[$id]) {//On met à jour les comptes sélectionné
							$infosActuelles -> execute(array('id' => $id));
							$arrayInfos = $infosActuelles -> fetch();
							$arrayChangements[] = $arrayInfos;
							echo $_POST['typeCompte'];
							echo $id;
						}
					}

					$arrayChangementsSerialise = serialize($arrayChangements);


				}


			echo "Action faite : ".$action ;
			setcookie("action", $action, time() + 7*24*60*60);
			setcookie("arrayChangementsSerialise", $arrayChangementsSerialise, time() + 7*24*60*60);

			} else if ($action == "mailMDP") {

				function RandomString(int $nbrcaracteres)
			    {//créer une chaine de caractère aléatoir avec minuscules, majuscules, chiffres (parfait pour des mdp aléatoire)
			        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			        $randstring = "";
			        for ($i = 0; $i < $nbrcaracteres; $i++) {
			            $randstring .= $characters[rand(0, strlen($characters)-1)];
			        }
			        return $randstring;
			    }


				foreach ($_POST as $idKey => $value) {

					$nouveauMDP = RandomString(10);
					$nouveauMDPhash = password_hash($nouveauMDP, PASSWORD_DEFAULT);

					$mailMDP = $bdd->prepare('SELECT mail FROM compte WHERE id = :id');
					$mailMDP -> execute(array('id' => $idKey));
					$mailMDP = $mailMDP -> fetch();
					$mailMDP = $mailMDP['mail'];
					if (filter_var($mailMDP, FILTER_VALIDATE_EMAIL)) {
						if (mail($mailMDP, " Votre nouveau mot de passe ", "votre nouveau mot de passe est: ".$nouveauMDP)) {
							echo "<p> mail envoyé pour: ".$mailMDP."</p>";
							$modifMDP = $bdd->prepare('UPDATE compte SET mdp = :nouveauMDPhash WHERE id = :id');
							$modifMDP -> execute(array('nouveauMDPhash' => $nouveauMDPhash,'id' => $idKey));
						} else{
							echo "<p> mail non envoyé pour: ".$mailMDP."</p>";
					  }
				}






				}
			}
		}?>

		<?php $users = $bdd->query('SELECT * FROM compte ORDER BY id DESC LIMIT 0,20') ?>


		<h3>Gestion des comptes</h3>
		<form method="post" action="backOfficeComptes.php">
			<table>


			   <tr>
			   		<th></th>
			      <th>Nom</th>
			      <th>Prénom</th>
			      <th>Mail</th>
			      <th>Type</th>
			   </tr>


			<?php while ( $user = $users->fetch() ) { ?>
					<?php if ($_SESSION['id'] != $user['id']) { ?>

						<tr>
							<td> <input type="checkbox" <?= 'name='.$user['id'];?> ></td>
					        <td> <?=$user['nom']?> </td>
					        <td> <?=$user['prenom']?> </td>
					        <td> <?=$user['mail']?> </td>

						    <td>
									<input type="hidden" <?= 'name='.$user['typeUtilisateur'];?> value="typeCompte">
									<select name="typeCompte">
									<option value="0" <?php if ($user['typeUtilisateur'] == 0) {
																		echo "selected";
																		} ?> >Admin</option>
									<option value="1" <?php if ($user['typeUtilisateur'] == 1) {
																		echo "selected";
																		} ?> >Gestionnaire</option>
									<option value="2" <?php if ($user['typeUtilisateur'] == 2) {
																		echo "selected";
																		} ?> >Utilisateur</option>
									<option value="3" <?php if ($user['typeUtilisateur'] == 3) {
																		echo "selected";
																		} ?> >Banni</option>
								 </select>
					      </td>
					   </tr>

					<?php } ?>
			<?php } ?>

			</table>




			<br/>
			<div class="bottomDescr">

			<button name="action" type="submit" value="modifier">Modifier</button>
			<button name="action" type="submit" value="mailMDP">Reinitialiser MDP</button>
			<button name="action" type="submit" value="supprimer">Supprimer</button>
			<button name="action" type="submit" value="annuler">Annuler</button>
		</form>
		</div>

		<div class="enregistrer">
			<a href="register.php?>"> Enregister nouveau compte </a> </li>
		</div>


		<div class="saut">
		</div>

        <?php include("footer.php"); ?>
	</body>

</html>
