<?php
	/* Database connection settings */
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e)
	{
		die('erreur:'.$e -> getMessage()); //Affiche un message en cas d'erreur
	}
	if (isset($_GET['profileid'])) {  //Si l'utilisateur a taper une ID dans l'url
		$currentid = htmlspecialchars($_GET['profileid']);
	}else {
				header("Location:graph.php?profileid=".urlencode($_SESSION['id']));
			}

	$data1 = '';

	$req = $bdd -> prepare("SELECT * FROM tests INNER JOIN compte ON compte.id = tests.id_examine WHERE id_examine = :id_examine OR id_examinateur = :id_examinateur");

	$req -> execute(array('id_examine' => $currentid,'id_examinateur' => $currentid));


	//loop through the returned data
	while ($test = $req->fetch()) {
		$data1 = $data1 . '"'. $test['score'].'",';

			echo "<p>(".$test['id_test'].") test du ".$test['date'].": ".$test['score']."</p>";
			echo "<legend><p>infos comp: ".$test['nom']." - ".$test['mail']."<p></legend>";
	}
	$data1 = trim($data1,",");
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
	</head>

	<body>	   
			<canvas id="chart" style="width: 150%; height: 100%; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>

			<script>
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'line',
		        data: {
		            labels: [1,2,3,4,5,6,7,8,9],
		            datasets: 
		            [{
		                label: 'Score',
		                data: [<?php echo $data1; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 3
		            },]
		        },
		     
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    });
			</script>
	</body>
</html>