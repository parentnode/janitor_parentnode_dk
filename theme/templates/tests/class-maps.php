<?



?>

<div class="scene i:scene tests">
	<h1>Maps</h1>	
	<h2>Maps Gateway</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests findBestRoute">
		<h3>MapsGateway::findBestRoute</h3>
		<? 
		if(1 && "findBestRoute – valid address, no options – return best route array") {

			(function() {
					
				// ARRANGE
				include_once("classes/helpers/maps.class.php");
				$MC = new MapsGateway();

				// ACT
				$best_route = $MC->findBestRoute("8250,Egå,Mejlgade 15", "8000,Banegårdsgade,Aarhus C");

				// ASSERT
				
				if(
					$best_route
				): ?>
				<div class="testpassed"><p>MapsGateway::getDirections – valid address, no options – return best route array – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>MapsGateway::getDirections – valid address, no options – return best route array – error</p></div>
				<? endif; 
				
				// CLEAN UP
	
			})();
		}
		?>
	</div>

</div>

<?

?>