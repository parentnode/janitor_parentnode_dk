<?php

$current_user = trim(shell_exec("whoami"));

// Get project path
$project_path = realpath(LOCAL_PATH."/..");


$test_1 = trim(shell_exec("cd '$project_path' && git pull"));


// Get git origin
$remote_origin = trim(shell_exec("cd '$project_path' && git config --get remote.origin.url"));
// Remove any existing username:password from remote url
$remote_origin = preg_replace("/(http[s]?):\/\/(([^:]+)[:]?([^@]+)@)?/", "$1://", $remote_origin);

// Get branch
$branch = trim(shell_exec("cd '$project_path' && git rev-parse --abbrev-ref HEAD"));

debug([$current_user, $project_path, $test_1, $remote_origin, $branch]);


?>

<div class="scene i:scene tests">
	<h1>git pull</h1>
	<h2>Enabling git pull via janitor</h2>
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