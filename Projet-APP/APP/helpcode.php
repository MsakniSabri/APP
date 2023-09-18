<?php
	$mdp = "mdp";
	$hash=password_hash($mdp,PASSWORD_DEFAULT);
	echo $hash;
?>