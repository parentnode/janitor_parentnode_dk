<?

?>

<div class="scene i:scene tests">
	<h1>#What#</h1>	
	<h2>#what does it do#</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests #method#">
		<h3>#Test name#</h3>
		<? 
		if(1 && "#method# – #test conditions# – #expected result#") {

			(function() {
					
				// ARRANGE
				// $IC = new Items();
				// $model_tests = $IC->typeObject("tests");

				// $test_item_id = $model_tests->createTestItem();
				// $test_user_id = $model_tests->createTestUser();

				// ACT
				
				
				// ASSERT 
				if(
					"Your first assertion"
					&& "Your second assertion"
				): ?>
				<div class="testpassed"><p>#Class#::#method# – #test conditions# – #expected result# – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>#Class#::#method# – #test conditions# – #expected result# – error</p></div>
				<? endif; 
				
				// CLEAN UP
				// $model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		}
		?>
	</div>

</div>

<?

?>