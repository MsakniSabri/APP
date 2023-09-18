<!DOCTYPE html>

<html lang="fr">

	<head>
		<title>Psitech</title>
		<link rel="stylesheet" href="CSS/index.css">
	</head>

	<body>
    <?php include("header.php");?>
		<?php include("diapo.php");?>

		<div>
    	<video width=100% height= 600 controls>
    		<source src="Media/tech.mp4" type="video/mp4">
     		Votre navigateur ne supporte pas ce type de video.
      </video>
  	</div>

		<div id="conteneur">
				<div class="element">
	      	<div>
		  			<img src="Media/easy.png" style="width: 450px;height: 500px;">
 					</div>
				<h1 class="text">
					<div>
					Facile à utiliser
					</div>
					<div>
					À la portée de tous
					</div>
					<div>
					Personnalisable
					</div>
				</h1>
			</div>
			<div class="element">
	                  <img src="Media/computer.png">
	            </div>
		</div>

	      <div id="conteneur">
	      	<div class="element">
	                  <img src="Media/brain.png">
	            </div >
			<div class="element">
	                  <img src="Media/idea.png" style="width: 400px;height: 500px;">
	                  <h1 class="text">
	                        <div>
	                        Détaillé
	                        </div>
	                        <div>
	                        Précis
	                        </div>
	                        <div>
	                        Compréhensible
	                        </div>
	                  </h1>
	            </div>

		</div>
		   	</section>
			</div>

			<!-- footer -->
	            <footer>
	                  <?php include("footer.php"); ?>
	            </footer>


		</body>
</html>
